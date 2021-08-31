<?php


namespace App\Actions\Tenant\SchoolClass\ClassSubject;


use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewClassSubjectAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        ClassSubject::query()->create($input);
    }
}
