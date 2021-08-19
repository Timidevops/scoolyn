<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Actions\Tenant\Admission\UpdateAdmissionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApplicantsController extends Controller
{
    public function index()
    {
        //@todo return view
        dd('');
        return view('', [
            'applicants' => AdmissionApplicant::query()->get(),
        ]);
    }

    public function single(string $uuid)
    {
        $applicant = AdmissionApplicant::query()->where('uuid', $uuid)->firstOrFail();
        //@todo return view
        dd('');

        return view('', [
            'applicant' => $applicant,
        ]);
    }

    public function update(string $uuid, Request $request)
    {
        //@todo validate request

        $applicant = AdmissionApplicant::query()->where('uuid', $uuid)->first();

        if( ! $applicant ){
            Session::flash('errorFlash', 'Error processing request');

            return back();
        }

        (new UpdateAdmissionAction())->execute($applicant, camel_to_snake($request->except(['_token', '_method'])));

        Session::flash('successFlash', 'Applicant updated successfully!!!');

        return back();
    }
}
