<?php


namespace App\Actions\Landlord\Plan;


use App\Models\Landlord\Plan;
use Ramsey\Uuid\Uuid;

class CreateNewPlanAction
{
    public function execute(array $input)
    {
        $input['uuid'] = (string) Uuid::uuid4();

        Plan::query()->create($input);
    }
}
