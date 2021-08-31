<?php


namespace App\Actions\Tenant\Student\StudentSubject;


use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewStudentSubjectAction
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $student->subjects()->create($input);
    }
}
