<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\SessionReport\ProcessSessionReportStatusAction;
use App\Http\Controllers\Controller;
use App\Jobs\Tenant\GenerateSessionResultJob;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResultSheetsController extends Controller
{
    public function index(string $classArmId)
    {
        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $students = collect($classArm->students)->map(function ($student){
            return Student::whereUuid($student);
        });

        $classArm->load([
            'schoolClass',
            'classSection',
            'classSectionCategory'
        ]);

        return view('Tenant.pages.result.academicResultSheet.index', [
            'classArm'     => $classArm,
            'students'     => $students,
            'totalStudent' => $students->count(),
            'classSubjects' => $classArm->classSubject,
        ]);
    }

    public function single(string $classArmId, string $studentId)
    {
        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $academicResult = $classArm->academicResultWithCurrentReport()->where('student_id', $studentId)->firstOrFail();

        $subjects = collect($academicResult->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->withoutGlobalScope('teacher')->first()->subject->subject_name);
        })->values();

        return view('Tenant.pages.result.academicResultSheet.single', [
            'academicResult'    => $academicResult,
            'subjects'          => $subjects,
            'classArmId'        => $classArmId,
            'studentId'         => $studentId,
            'approvedResult'    => $academicResult->status === AcademicResult::APPROVED_RESULT_STATUS,
            'disapprovedResult' => $academicResult->status === AcademicResult::DISAPPROVED_RESULT_STATUS,
        ]);

    }

    public function update(string $classArmId, string $studentId, Request $request)
    {
        $classArm =  ClassArm::whereUuid($classArmId)->first();

        $academicResult = $classArm->academicResultWithCurrentReport()->where('student_id', $studentId)->first();

        if ( ! $classArm || ! $academicResult ){
            Session::flash('errorFlash', 'Error processing request, try again.');

            return back();
        }

        $lastTerm = AcademicTerm::all()->last();

//        if ( $request->has('disapprove') ){
//            Session::flash('successFlash', 'Academic result disapproved successfully!!!');
//
//            $academicResult->setStatus(AcademicResult::DISAPPROVED_RESULT_STATUS);
//        }
//
        if ( $request->has('approve') ){

            $academicResult->setStatus(AcademicResult::APPROVED_RESULT_STATUS);

            $academicResult->term == $lastTerm->uuid ? (new ProcessSessionReportStatusAction)->execute($classArm) : null;

            Session::flash('successFlash', 'Academic result approved successfully!!!');

        }

        return back();
    }

}
