<?php


namespace App\Actions\Landlord\Plan;


use Illuminate\Database\Eloquent\Model;

class CreateNewPlanFeatureAction
{
    public function execute(Model $plan, array $input)
    {
        $plan->features()->create($input);
    }
}
