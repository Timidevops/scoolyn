<?php


namespace App\Actions\Tenant\Student\StudentSubject;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewStudentSubject
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $student->subjects()->create($input);
    }
}
