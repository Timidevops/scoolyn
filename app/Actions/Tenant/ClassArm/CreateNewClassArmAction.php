<?php


namespace App\Actions\Tenant\ClassArm;


use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Setting;
use Ramsey\Uuid\Uuid;

class CreateNewClassArmAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $input['academic_term_id']    = Setting::getCurrentAcademicTermId();

        ClassArm::query()->create($input);
    }
}
