<?php


namespace App\Actions\Landlord\Subscription;


use App\Models\Landlord\PlanFeatureAddon;

class CreateNewSubscriptionAddonAction
{
    public function execute(array $input)
    {
        PlanFeatureAddon::query()->create($input);
    }
}
