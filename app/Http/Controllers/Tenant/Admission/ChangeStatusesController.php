<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Actions\Tenant\Admission\UpdateAdmissionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangeStatusesController extends Controller
{
    public function update(array $input)
    {
        if( ! $input['applicantIds'] ){
            Session::flash('errorFlash', 'Kindly select at least one applicant');

            return;
        }

        foreach ($input['applicantIds'] as $applicantId){

            $applicant = AdmissionApplicant::query()->where('uuid', $applicantId)->first();

            if( ! $applicant ){
                continue;
            }

            //@todo transfer applicant information to student if status is admitted

            $applicant['status'] = $input['status'];

            $applicant->save();
        }

    }
}
