<?php


namespace App\Actions\Tenant\Result\Broadsheet;


use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewBroadsheetAction
{
    public function execute(Model $classSubject, array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        return $classSubject->academicBroadsheet()->create($input);
    }
}
