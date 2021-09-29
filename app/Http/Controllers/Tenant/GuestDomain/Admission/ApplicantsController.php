<?php

namespace App\Http\Controllers\Tenant\GuestDomain\Admission;

use App\Actions\Tenant\guestDomain\Admission\CreateNewAdmissionApplicant;
use App\Actions\Tenant\guestDomain\Admission\UploadPassportAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ApplicantsController extends Controller
{
    public function create()
    {
        return view('tenant.guestDomain.admission.index', [
            'schoolName' => Setting::schoolDetails()['schoolName'],
            'schoolLocation' => Setting::schoolDetails()['schoolLocation'],
            'schoolNumber' => Setting::schoolDetails()['contactNumber'],
            'schoolEmail' => Setting::schoolDetails()['contactEmail'],
            'schoolWebsite' => Setting::schoolDetails()['schoolName'] ?? '',
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
            'file' => ['required', 'file', 'image', 'max:10240'],
        ]);

        //upload passport
        $request['passport'] = (new UploadPassportAction())->execute([
            'passport' => $request->file('file'),
            'firstName' => $request->input('studentFirstName'),
            'lastName' => $request->input('studentLastName'),
        ]);

        //store admission
        (new CreateNewAdmissionApplicant())->execute( camel_to_snake($request->except('_token','file')) );

        //@todo integrate payment option

        Session::flash('successFlash', 'Admission form submitted successfully!!!');

        return back();

    }


}
