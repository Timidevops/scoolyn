<?php


namespace App\Actions\Tenant\Admission;


use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Database\Eloquent\Model;

class UpdateAdmissionAction
{
    public function execute(Model $applicant, array $input)
    {
        if( $applicant->status == AdmissionApplicant::ADMITTED_STATUS || $applicant->status == AdmissionApplicant::CLASS_ARM_ADDED ){
            return;
        }

        $applicant->update($input);

    }
}
