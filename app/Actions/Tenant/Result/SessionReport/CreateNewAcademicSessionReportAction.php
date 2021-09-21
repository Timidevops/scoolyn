<?php


namespace App\Actions\Tenant\Result\SessionReport;


use App\Models\Tenant\AcademicSessionResult;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewAcademicSessionReportAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        return AcademicSessionResult::query()->create($input);
    }
}
