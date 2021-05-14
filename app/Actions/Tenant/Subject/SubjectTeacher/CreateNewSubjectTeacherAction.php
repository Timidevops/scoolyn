<?php


namespace App\Actions\Tenant\Subject\SubjectTeacher;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSubjectTeacherAction
{
    public function execute(Model $model, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $model->subjectTeacher()->create($input);
    }
}
