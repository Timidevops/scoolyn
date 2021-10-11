<?php


namespace App\Actions\Landlord\Subscription;


use App\Models\Landlord\FeatureChecker;
use App\Models\Landlord\PlanFeatureAddon;

class CreateNewSubscriptionAddonAction
{
    public function execute(array $input)
    {
        $featureAddon = FeatureChecker::featureTotalStudentAddons()->first();

        if ( ! $featureAddon ){
            PlanFeatureAddon::query()->create($input);
        }

        $featureAddon->update([
            'value' => $featureAddon->value + $input['value'],
            'value_left' => $featureAddon->value_left + $input['value_left'],
        ]);

    }
}
