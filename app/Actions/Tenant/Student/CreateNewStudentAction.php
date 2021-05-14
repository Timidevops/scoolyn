<?php


namespace App\Actions\Tenant\Student;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewStudentAction
{
    public function execute(Model $parent, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $parent->ward()->create($input);
    }
}
