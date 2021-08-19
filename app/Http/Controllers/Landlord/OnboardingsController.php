<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\SchoolAdmin;
use App\Models\Landlord\Transaction;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class OnboardingsController extends Controller
{
    protected Model $tenant;

    public function create(string $uuid)
    {
        //@todo return view

        return $this->store($uuid);
    }

    public function store(string $uuid)
    {
        //@todo validate request

        $request = [
            'schoolName' => 'digikraaft high school',
            'schoolLocation' => 'ibadan',
            'paymentCurrency' => 'ngn',
            'domainName' => 'dhc',
            'adminName' => 'admin',
            'adminPassword' => 'asd',
            'adminEmail' => 'admin@dhc.com',
        ];

        $schoolAdmin = SchoolAdmin::query()->where('uuid', $uuid)->first();

        $schoolDomain = $request['domainName'].'.'.config('env.app_domain');

        //@todo filter name to under_score helper function regex
        $schoolName = str_replace(' ', '_', $request['schoolName']);

        //create new tenant
        $this->tenant = $this->createNewTenant([
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
        $this->createNewAdminUser([
            'uuid' => Uuid::uuid4(),
            'name' => $request['adminName'],
            'email' => $request['adminEmail'],
            'password' => Hash::make($request['adminPassword']),
        ]);

        //create initial settings
        $this->runInitialSettings(camel_to_snake($request));

        //update onboard process to complete and add tenant id
        $schoolAdmin->update([
            'setup_complete' => 1,
            'tenant_id' => $this->tenant->id,
        ]);

        //update initial subscription transaction
        $this->updateTransaction($schoolAdmin->email);

        return redirect()->to("http://${$schoolDomain}");
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    private function createNewTenant(array $input)
    {
        return ScoolynTenant::query()->create($input);
    }

    private function createNewAdminUser(array $input)
    {
        $admin =  User::query()->create($input);

        $admin->assignRole(User::SUPER_ADMIN_USER);
    }

    private function updateTransaction(string $userReference)
    {
        $transaction = Transaction::query()->where('user_reference', $userReference)->first();

        $transaction->update([
            'tenant_id' => $this->tenant->id,
        ]);
    }

    private function runInitialSettings(array $input)
    {
        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_NAME_SETTING,
            'setting_value' => $input['school_name'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_LOCATION_SETTING,
            'setting_value' => $input['school_location'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::PAYMENT_CURRENCY,
            'setting_value' => $input['payment_currency'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::ADMISSION_STATUS,
            'setting_value' => '0',
        ]);
    }
}
