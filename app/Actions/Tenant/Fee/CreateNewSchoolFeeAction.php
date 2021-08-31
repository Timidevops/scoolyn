<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolFeeAction
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        return $student->schoolFee()->create($input);
    }
}
