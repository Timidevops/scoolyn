<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Tenant;

use App\Actions\Landlord\Onboarding\CreateDummyParentAction;
use App\Actions\Landlord\Onboarding\CreateNewAdminUserAction;
use App\Actions\Landlord\Onboarding\CreateNewTenantAction;
use App\Actions\Landlord\Onboarding\RunInitialSettingsAction;
use App\Actions\Landlord\SchoolAdmin\CreateNewSchoolAdminAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Landlord\School\StoreSchoolRequest;
use App\Models\Tenant\ScoolynTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class TenantsController extends Controller
{
    public function index()
    {
        return view('Landlord.adminDomain.pages.tenant.index', [
            'schools'      => ScoolynTenant::query()->get(['name', 'domain']),
            'totalSchools' => ScoolynTenant::query()->count(),
        ]);
    }

    public function create()
    {
        return view('Landlord.adminDomain.pages.tenant.create', [
            'domain' => (string) config('env.app_domain'),
        ]);
    }

    public function store(StoreSchoolRequest $request)
    {

        //dd($request->all());


        $inputDomain = str_replace(' ', '-', $request->input('domainName'));

        $schoolDomain = (string) $inputDomain.'.'.config('env.app_domain');

        //create school admin
        $schoolAdmin = (new CreateNewSchoolAdminAction)->execute([
            'uuid' => (string) Uuid::uuid4(),
            'email' => $request->input('adminEmail'),
            'initial_plan' => 1,
        ]);

        //@todo filter name to under_score helper function regex
        $schoolName = str_replace(' ', '_', $request->input('schoolName'));

        //create new tenant
        $tenant = (new CreateNewTenantAction)->execute([
            'name' => $schoolName,
            'domain' => $schoolDomain,
        ]);

        $tenant->makeCurrent();


        //@todo add subscription

        //db migration
        Artisan::call('migrate:fresh',[
            '--path' => 'database/migrations/tenants',
            '--database' => 'tenant'
        ]);

        //db seeding
        Artisan::call('db:seed',[
            '--class' => "DatabaseSeeder",
            '--database' => 'tenant',
        ]);

        //create new admin user
        $adminUser = (new CreateNewAdminUserAction)->execute([
            'uuid' => Uuid::uuid4(),
            'name' => 'Administrator',
            'email' => $schoolAdmin->email,
            'password' => Hash::make($request['adminPassword']),
        ]);

        //create initial settings
        (new RunInitialSettingsAction)->execute(camel_to_snake($request->all()));

        //create dummy parent
        (new CreateDummyParentAction)->execute($adminUser);

        //update onboard process to complete and add tenant id
        $schoolAdmin->update([
            'setup_complete' => 1,
            'tenant_id' => $tenant->id,
        ]);

        Session::flash('successFlash', 'School added successfully!!!');

        return back();
    }
}
