<?php

namespace App\Http\Controllers\Tenant\Admission;

use App\Actions\Tenant\Admission\UpdateAdmissionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AdmissionApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ApplicantsController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.admission.index', [
            'applicants' => AdmissionApplicant::query()->get(),
            'totalApplicants' => AdmissionApplicant::query()->count(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'admissionStatus' => ['nullable', Rule::in([AdmissionApplicant::ADMITTED_STATUS, AdmissionApplicant::REJECTED_STATUS])],
            'examDate' => ['nullable', 'date'],
            'selectedId' => ['nullable', 'array'],
        ]);

        if( $request->input('admissionStatus') ){
            (new ChangeStatusesController())->update([
                'applicantIds' => $request->input('selectedId'),
                'status' => $request->input('admissionStatus'),
            ]);
        }

        if( $request->input('examDate') ){
            (new ScheduleExamsController())->update([
                'applicantIds' => $request->input('selectedId'),
                'examSchedule' => $request->input('examDate'),
            ]);
        }

        Session::flash('successFlash', 'Updated successfully!!!');

        return back();
    }

    public function single(string $uuid)
    {
        $applicant = AdmissionApplicant::query()->where('uuid', $uuid)->firstOrFail();

        return view('Tenant.pages.admission.single', [
            'applicant' => $applicant,
        ]);
    }

    public function update(string $uuid, Request $request)
    {
        $this->validate($request, [
            'admissionStatus' => ['nullable', Rule::in([AdmissionApplicant::ADMITTED_STATUS, AdmissionApplicant::REJECTED_STATUS])],
            'examDate' => ['nullable', 'date'],
        ]);

        $applicant = AdmissionApplicant::query()->where('uuid', $uuid)->first();

        if( ! $applicant ){
            Session::flash('errorFlash', 'Error processing request');

            return back();
        }

        (new UpdateAdmissionAction())->execute($applicant, [
            'status' => $request->input('admissionStatus') ?? $applicant->status,
            'exam_schedule' => $request->input('examDate') ?? $applicant->exam_schedule,
        ]);

        Session::flash('successFlash', 'Applicant updated successfully!!!');

        return back();
    }
}
