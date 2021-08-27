<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\SchoolAdmin;
use App\Models\Landlord\Transaction;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\Parents;
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
        $this->adminUser = $this->createNewAdminUser([
            'uuid' => Uuid::uuid4(),
            'name' => 'Administrator',
            'email' => $schoolAdmin->email,
            'password' => Hash::make($request['adminPassword']),
        ]);

        //create initial settings
        $this->runInitialSettings(camel_to_snake($request->all()));

        //create dummy parent
        $this->createDummyParent();

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

        return $admin;
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
            'setting_name' => Setting::CONTACT_NUMBER_SETTING,
            'setting_value' => $input['contact_number'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::CONTACT_EMAIL_SETTING,
            'setting_value' => $input['school_email'],
        ]);

        Setting::query()->create([
            'setting_name' => Setting::SCHOOL_TYPE_SETTING,
            'setting_value' => $input['school_type'],
        ]);

        $paymentStatus = 0;
        if($input['has_payment'] == 'yes'){

            $paymentStatus = 1;

            Setting::query()->create([
                'setting_name' => Setting::PAYMENT_CURRENCY,
                'setting_value' => $input['payment_currency'],
            ]);
        }

        Setting::query()->create([
            'setting_name' => Setting::PAYMENT_STATUS,
            'setting_value' => (string) $paymentStatus,
        ]);

        Setting::query()->create([
            'setting_name' => Setting::ADMISSION_STATUS,
            'setting_value' => '0',
        ]);

        Setting::query()->create([
            'setting_name' => Setting::INITIAL_TODO_SETTING,
            'setting_value' => '0',
            'meta' =>  [
                [
                    'name' => OnboardingTodoList::SET_ACADEMIC_CALENDAR,
                    'done' => 0,
                    'description' => 'Goto settings to set academic calendar',
                    'url' => 'academicSession',
                ],
                [
                    'name' => OnboardingTodoList::ADD_SCHOOL_CLASSES,
                    'done' => 0,
                    'description' => 'Goto Classes to add class arm',
                    'url' => 'listClass',
                ],
                [
                    'name' => OnboardingTodoList::ADD_SUBJECT,
                    'done' => 0,
                    'description' => 'Goto subject to add subject',
                    'url' => 'listSubject',
                ],
                [
                    'name' => OnboardingTodoList::ADD_CA_FORMAT,
                    'done' => 0,
                    'description' => 'Goto Results / Continuous assessment format to c.a format',
                    'url' => 'createCAStructure',
                ],
                [
                    'name' => OnboardingTodoList::ADD_GRADING_FORMAT,
                    'done' => 0,
                    'description' => 'Goto Results / Academic grading format to add grading format',
                    'url' => 'createGradeFormat',
                ],
                [
                    'name' => OnboardingTodoList::ADD_STUDENT,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add student',
                    'url' => 'createStudent',
                ],
                [
                    'name' => OnboardingTodoList::ADD_PARENT,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add parent',
                    'url' => 'createParent',
                ],
                [
                    'name' => OnboardingTodoList::ADD_TEACHER,
                    'done' => 0,
                    'description' => 'Goto Users / Student to add teacher',
                    'url' => 'createTeacher',
                ],
                [
                    'name' => OnboardingTodoList::SET_SCHOOL_DETAIL,
                    'done' => 0,
                    'description' => 'Goto settings / School details to set school details',
                    'url' => 'schoolDetailsSettings',
                ],
            ],
        ]);
    }

    private function createDummyParent()
    {
        Parents::query()->create([
            'uuid' => Uuid::uuid4(),
            'user_id' => (string) $this->adminUser->uuid,
            'first_name' => 'dummy',
            'last_name' => 'parent',
            'email' => 'dummy@scoolyn.com',
            'phone_number' => '12345',
            'gender' => 'male',
        ]);
    }
}
