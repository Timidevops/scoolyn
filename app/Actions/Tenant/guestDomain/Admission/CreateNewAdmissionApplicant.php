<?php


namespace App\Actions\Tenant\guestDomain\Admission;


use App\Models\Tenant\AdmissionApplicant;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewAdmissionApplicant
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $input['status'] = AdmissionApplicant::APPLIED_STATUS;

        AdmissionApplicant::query()->create($input);
    }
}
