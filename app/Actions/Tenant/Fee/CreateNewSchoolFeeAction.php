<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolFeeAction
{
    public function execute(Model $student, array $input)
    {

        if ( ! $student->schoolFee()->exists() ){

            $input['uuid'] = Uuid::uuid4();

            $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

            $schoolFee = $student->schoolFee()->create($input);

            $schoolFee->setStatus(SchoolFee::NOT_PAID_STATUS);

            return;
        }

        //fee_structure_id
        $amount = $student->schoolFee->amount + $input['amount'];

        $feeStructureId = collect($student->schoolFee->fee_structure_id)->merge($input['fee_structure_id']);

         $student->schoolFee()->update([
             'amount' => $amount,
             'fee_structure_id' => $feeStructureId,
         ]);
    }
}
