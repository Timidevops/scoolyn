<?php


namespace App\Actions\Tenant\ClassArm;


use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewClassArmAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        return ClassArm::query()->create($input);
    }
}
