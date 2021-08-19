<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Actions\Tenant\Admission\UpdateAdmissionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangeStatusesController extends Controller
{
    public function update(Request $request)
    {
        //@todo validate request

        $applicantIds = $request->input('applicantId');

        foreach ($applicantIds as $applicantId){

            $applicant = AdmissionApplicant::query()->where('uuid', $applicantId)->first();

            if( ! $applicant ){
                continue;
            }

            $applicant['status'] = $request->input('status');

            $applicant->save();
        }

        Session::flash('successFlash', 'Applicants status updated successfully!!!');

        return back();
    }
}
