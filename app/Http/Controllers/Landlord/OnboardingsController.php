<?php

namespace App\Http\Controllers\Landlord;

use App\Actions\Landlord\Onboarding\CreateDummyParentAction;
use App\Actions\Landlord\Onboarding\CreateNewAdminUserAction;
use App\Actions\Landlord\Onboarding\CreateNewTenantAction;
use App\Actions\Landlord\Onboarding\RunInitialSettingsAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\SchoolAdmin;
use App\Models\Landlord\Transaction;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class OnboardingsController extends Controller
{
    protected Model $tenant;

    protected $adminUser;

    public function create(string $uuid)
    {
        $schoolAdmin  = SchoolAdmin::query()->where('uuid', $uuid)->first();

        return view('Landlord.pages.onboarding.index', [
            'id' => $uuid,
            'domain' => (string) config('env.app_domain'),
            'email' => $schoolAdmin->email,
        ]);
    }

    public function store(string $uuid, Request $request)
    {
        $this->validate($request, [
            'schoolName' => ['required'],
            'schoolType' => ['required', Rule::in(['private', 'public'])],
            'schoolLocation' => ['required'],
            'contactNumber' => ['required'],
            'schoolEmail' => ['nullable'],
            'hasPayment' => ['required', Rule::in(['yes', 'no'])],
            'paymentCurrency' => ['nullable', Rule::in(['ngn'])],
            'domainName' => ['required'],
            'adminPassword' => ['required','min:8','confirmed'],
        ]);

        $inputDomain = str_replace(' ', '-', $request->input('domainName'));

        $schoolDomain = (string) $inputDomain.'.'.config('env.app_domain');

        if( $this->validateDomain($schoolDomain) ){
            return back()->withInput($request->input())->withErrors([
                'domainName' => 'Domain already exist.'
            ]);
        }

        $schoolAdmin = SchoolAdmin::query()->where('uuid', $uuid)->first();

        //@todo filter name to under_score helper function regex
        $schoolName = str_replace(' ', '_', $request->input('schoolName'));

        //create new tenant
        $this->tenant = (new CreateNewTenantAction)->execute([
            'name' => $schoolName,
            'domain' => $schoolDomain,
        ]);

        $this->tenant->makeCurrent();

        //add subscription
        $subscription = Plan::find($schoolAdmin->initial_plan);

        $this->tenant->newSubscription('main', $subscription);

        //db migration
        Artisan::call('migrate:fresh',[
            '--path' => 'database/migrations/tenants'
        ]);

        //db seeding
        Artisan::call('db:seed',[
            '--class' => "DatabaseSeeder"
        ]);

        //create new admin user
        $this->adminUser = (new CreateNewAdminUserAction)->execute([
            'uuid' => Uuid::uuid4(),
            'name' => 'Administrator',
            'email' => $schoolAdmin->email,
            'password' => Hash::make($request['adminPassword']),
        ]);

        //create initial settings
        (new RunInitialSettingsAction)->execute(camel_to_snake($request->all()));

        //create dummy parent
        (new CreateDummyParentAction)->execute($this->adminUser);

        //update onboard process to complete and add tenant id
        $schoolAdmin->update([
            'setup_complete' => 1,
            'tenant_id' => $this->tenant->id,
        ]);

        //update initial subscription transaction
        $this->updateTransaction($schoolAdmin->email);

        return redirect()->to("http://{$schoolDomain}/login");
    }

    private function validateDomain(string $domain) : bool
    {
        return ScoolynTenant::query()->where('domain', $domain)->exists();
    }

    private function updateTransaction(string $userReference)
    {
        $transaction = Transaction::query()->where('user_reference', $userReference)->first();

        $transaction->update([
            'tenant_id' => $this->tenant->id,
        ]);
    }
}
