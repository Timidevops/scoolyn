<?php


namespace App\Actions\Tenant\ClassArm;


use App\Models\Tenant\ClassArm;
use Ramsey\Uuid\Uuid;

class CreateNewClassArmAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        ClassArm::query()->create($input);
    }
}
