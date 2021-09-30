<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Student\AttachSubjectsToStudents;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentSubjectsController extends Controller
{
    public function index(string $uuid){

        $student = Student::query()->where('uuid', $uuid)->firstOrFail();

        $studentSubject = $student->subjects
            ? ClassSubject::query()->whereIn('uuid', $student->subjects->subjects)->get('subject_id')
            : [];


        $student->subjects ? $studentSubject->load('subject') : null;

        $totalSubject   = count($studentSubject);

        $studentSubjectIds = $student->subjects ? $student->subjects->subjects : [];

        $classSubjects = $student->classArm->getClassSubjects();

        $classSubjects = $classSubjects->whereNotIn('uuid', $studentSubjectIds);

        $classSubjects->load('subject');

        return view('tenant.pages.student.subject.index', [
            'studentId'      => $student->uuid,
            'totalSubject'   => $totalSubject,
            'studentName'    => "{$student->first_name} {$student->last_name}",
            'classSubjects'  => collect($classSubjects)->values(),
            'studentSubject' => collect($studentSubject),
        ]);
    }

    public function store(string $uuid, Request $request)
    {

        $this->validate($request, [
            'subjects.*' => ['required','unique:'.config('env.tenant.tenantConnection').'.school_subjects,subject_id'],
            'subjects'   => ['required', 'array','min:1']
        ]);

        $student = Student::whereUuid($uuid);

        (new AttachSubjectsToStudents($student))->execute($request->input('subjects'));

        Session::flash('successFlash', 'Subject added successfully!!!');

        return back();
    }
}
