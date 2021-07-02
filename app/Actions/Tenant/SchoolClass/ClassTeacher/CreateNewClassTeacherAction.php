<?php


namespace App\Actions\Tenant\SchoolClass\ClassTeacher;


use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassTeacher;
use Ramsey\Uuid\Uuid;

class CreateNewClassTeacherAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        //ClassTeacher::query()->create($input);
        ClassArm::query()->create($input);
    }
}
