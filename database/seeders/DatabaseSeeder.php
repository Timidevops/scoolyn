<?php

namespace Database\Seeders;

use App\Models\Tenant\ScoolynTenant;
use Database\Seeders\Landlord\FeatureSeeder;
use Database\Seeders\Landlord\SubscriptionPlanSeeder;
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
            RoleSeeder::class,
            SubjectSeeders::class,
        ]);
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
        $this->call([
            \Database\Seeders\Landlord\UserSeeder::class,
        ]);
    }
}
