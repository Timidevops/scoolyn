<?php

namespace App\Http\Controllers\Tenant\GuestDomain\Admission;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class ApplicantsController extends Controller
{
    public function create()
    {
        return view('Tenant.guestDomain.admission.index', [
            'schoolName' => 'digikraaft high school',
            'schoolLocation' => 'ibadan',
            'schoolNumber' => '12345',
            'schoolEmail' => 'admin@dhc.com',
            'schoolWebsite' => 'www.dhc.com',
        ]);
    }

    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'studentFirstName' => ['required'],
            'studentLastName' => ['required'],
            'studentOtherName' => ['required'],
            'studentGender' => ['required', Rule::in(['male', 'female'])],
            'studentDob' => ['required', 'date'],
            'studentReligion' => ['required', Rule::in(['christian', 'muslim'])],
            'studentAddress' => ['required'],
            'previousSchool' => ['required'],
            'previousClass' => ['required'],
            'class' => ['required'],
            'section' => ['nullable', Rule::in(['science', 'arts', 'commercial'])],
            'guardianName' => ['required'],
            'guardianRelationship' => ['required'],
            'guardianContactNumber' => ['required'],
            'guardianContactEmail' => ['nullable', 'email'],
            'guardianAddress' => ['required'],
            'guardianProfession' => ['nullable', 'string'],
        ]);

        //store admission
        $this->createNewAdmission(camel_to_snake($request->except('_token')));

        //@todo integrate payment option

        Session::flash('successFlash', 'Admission form submitted successfully!!!');

        return back();

    }

    private function createNewAdmission(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();

        $input['status'] = AdmissionApplicant::APPLIED_STATUS;

        AdmissionApplicant::query()->create($input);
    }
}
