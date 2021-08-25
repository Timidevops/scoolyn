<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ScheduleExamsController extends Controller
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

            $applicant['exam_schedule'] = $input['examSchedule'];

            $applicant['status'] = AdmissionApplicant::EXAM_SCHEDULED_STATUS;

            $applicant->save();
        }

    }
}
