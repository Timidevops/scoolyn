<?php

namespace Database\Seeders;

use App\Models\Tenant\ScoolynTenant;
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
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
    }
}
