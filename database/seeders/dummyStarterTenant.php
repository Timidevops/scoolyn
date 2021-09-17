<?php

namespace Database\Seeders;

use App\Actions\Landlord\Onboarding\RunInitialSettingsAction;
use Illuminate\Database\Seeder;

class dummyStarterTenant extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new UserSeeder())->run();

        (new RunInitialSettingsAction())->execute([
            'school_name' => 'Digikraaft High School',
            'school_location' => 'Ibadan',
            'contact_number' => '123',
            'school_email' => 'dhc@gm.com',
            'school_type' => 'private',
            'payment_currency' => 'ngn',
            'has_payment' => 'yes'
        ]);
    }
}
