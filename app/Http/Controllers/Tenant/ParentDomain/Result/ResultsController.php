<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $parent = Auth::user()->parent;

        $wards  =  $parent->ward()->get('uuid')->toArray();

        $results = AcademicResult::query()->whereIn('student_id', $wards)->get();

        $results = $results->filter(function ($result){
            return $result->status == AcademicResult::APPROVED_RESULT_STATUS;
        });

        $results->load(['student', 'academicSession']);

        return view('livewire.tenant.parent-domain.result.index', [
            'results' => $results,
            'filterResult' => $request->has('ward') ? $request->has('ward') : '',
        ]);
    }

    public function single(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        if ( ! $ward->schoolFee->isSchoolFeesPaid() ){
            Session::flash('warningFlash', 'Kindly pay school fees to access result.');
            return redirect()->route('singleWardFee',[$ward->schoolFee->uuid, $ward->uuid]);
        }

        $result = $ward->academicReport()->where('uuid', $uuid)->firstOrFail();

        if ( $result->status == AcademicResult::APPROVED_RESULT_STATUS ){
            abort(404);
        }

        $result->load(['student', 'academicSession', 'classArm']);

        $subjects = collect($result->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->first()->subject->subject_name);
        })->values();


        return view('Tenant.parentDomain.result.single', [
            'result' => $result,
            'subjects' => $subjects,
        ]);
    }
}
