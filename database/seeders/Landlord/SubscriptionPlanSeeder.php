<?php

namespace Database\Seeders\Landlord;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = app('rinvex.subscriptions.plan')->create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'price' => 9.99,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'USD',
            'uuid' => Uuid::uuid4(),
        ]);
    }
}
