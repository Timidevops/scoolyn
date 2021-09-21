<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

class SessionResultsController extends Controller
{
    public function index(string $classArmId, string $studentId)
    {
        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        if ( ! $classArm->hasStudent($studentId) ){
            abort(404);
        }

        $subjects = collect(Student::whereUuid($studentId)->academicSessionResult()->first()->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->withoutGlobalScope('teacher')->first()->subject->subject_name);
        })->values();

        return view('Tenant.pages.result.sessionResultSheet.index', [
            'student'         => Student::whereUuid($studentId),
            'classArm'        => $classArm,
            'sessionResult'   => Student::whereUuid($studentId)->academicSessionResult()->first(),
            'academicSession' => AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId()),
            'subjects'        => $subjects,
        ]);
    }
}
