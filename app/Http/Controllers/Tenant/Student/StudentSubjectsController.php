<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Student\StudentSubject\CreateNewStudentSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

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

        //@todo whereJsonContain [class_section_id,... ] etc
        $classSubjects = ClassSubject::query()->whereNotIn('uuid', $studentSubjectIds)
            ->where('school_class_id', $student->classArm->school_class_id)
            //->Where('class_section_id', $student->class_section_id)
            //->Where('class_section_category_id', $student->class_section_category_id)
            ->get();


        $classSubjects->load('subject');

        return view('Tenant.pages.student.subject.index', [
            'studentId'      => $student->uuid,
            'totalSubject'   => $totalSubject,
            'studentName'    => "{$student->first_name} {$student->last_name}",
            'classSubjects'  => $classSubjects,
            'studentSubject' => collect($studentSubject),
        ]);
    }

    public function create(string $uuid)
    {
        $student = Student::query()->where('uuid', $uuid)->firstOrFail();

        return view('Tenant.pages.student.subject.create', [
            'studentId' => $student->uuid,
        ]);
    }

    public function store(string $uuid, Request $request)
    {
        $this->validate($request, [
            'subjects' => ['required','array']
        ]);

        $student = Student::query()->where('uuid', '=', $uuid)->first();

        if( ! $student->subjects ){

            (new CreateNewStudentSubjectAction())->execute($student, [
                'subjects' => $request->input('subjects'),
            ]);

            return back();
        }

        $student->subjects->subjects = collect($student->subjects->subjects)->merge($request->input('subjects'));

        $student->subjects->save();

        return back();
    }
}
