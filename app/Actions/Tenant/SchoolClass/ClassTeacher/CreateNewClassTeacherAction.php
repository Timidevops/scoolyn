<?php


namespace App\Actions\Tenant\SchoolClass\ClassTeacher;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewClassTeacherAction
{
    public function execute(Model $model, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $model->classTeacher()->create($input);
    }
}
