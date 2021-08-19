<?php

namespace App\Http\Controllers\Tenant\GuestDomain\Admission;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ApplicantsController extends Controller
{
    public function create()
    {
        //@todo return view
        dd('here');
    }

    public function store(Request $request)
    {
        //@todo validate request

        //@todo store admission
        $this->createNewAdmission(camel_to_snake($request->except('_token')));

    }

    private function createNewAdmission(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $input['academic_term_id']    = Setting::getCurrentAcademicTermId();

        $input['status'] = AdmissionApplicant::APPLIED_STATUS;

        AdmissionApplicant::query()->create($input);
    }
}
