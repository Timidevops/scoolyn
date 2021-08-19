<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ScheduleExamsController extends Controller
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

            $applicant['exam_schedule'] = $request->input('examSchedule');

            $applicant->save();
        }

        Session::flash('successFlash', 'Applicants exam date scheduled successfully!!!');

        return back();
    }
}
