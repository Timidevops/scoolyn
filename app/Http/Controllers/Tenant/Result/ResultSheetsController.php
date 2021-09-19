<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use Illuminate\Support\Facades\Auth;

class ResultSheetsController extends Controller
{
    public function index(string $classArmId)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

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
        ]);
    }

    public function single(string $classArmId, string $studentId)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $academicResult = $classArm->academicResultWithCurrentReport()->where('student_id', $studentId)->firstOrFail();

        $subjects = collect($academicResult->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->withoutGlobalScope('teacher')->first()->subject->subject_name);
        })->values();

        return view('Tenant.pages.result.academicResultSheet.single', [
            'academicResult' => $academicResult,
            'subjects'       => $subjects,
            'classArmId'     => $classArmId,
            'studentId'      => $studentId,
        ]);

    }

}
