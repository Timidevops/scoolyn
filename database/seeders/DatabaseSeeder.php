<?php

namespace Database\Seeders;

use App\Models\Tenant\ScoolynTenant;
use Database\Seeders\Landlord\FeatureSeeder;
use Database\Seeders\Tenant\AcademicTermSeeder;
use Database\Seeders\Tenant\NewPermissionSeeder;
use Database\Seeders\Tenant\PermissionSeeder;
use Database\Seeders\Tenant\RoleSeeder;
use Database\Seeders\Tenant\SchoolClassesSeeder;
use Database\Seeders\Tenant\SubjectSeeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ScoolynTenant::checkCurrent()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        // run tenant specific seeders
        $this->call([
            PermissionSeeder::class,
            NewPermissionSeeder::class,
            RoleSeeder::class,
            SubjectSeeders::class,
            AcademicTermSeeder::class,
            SchoolClassesSeeder::class,
        ]);
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
        $this->call([
            \Database\Seeders\Landlord\UserSeeder::class,
            FeatureSeeder::class,
        ]);
    }
}
