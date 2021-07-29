<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;


use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewResultSheetAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $input['academic_term_id']    = Setting::getCurrentAcademicTermId();

        return AcademicResult::query()->create($input);
    }
}
