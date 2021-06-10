<?php


namespace App\Actions\Tenant\Subject\SubjectTeacher;

use App\Models\Tenant\SubjectTeacher;
use Ramsey\Uuid\Uuid;

class CreateNewSubjectTeacherAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        SubjectTeacher::query()->create($input);
    }
}
