<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Student\StudentSubject\CreateNewStudentSubjectAction;
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

        $classArm = $student->classArm;

        $classSubjects = $student->classArm->classSubject->filter(function ($classSubject) use($classArm){

            if($classSubject->class_arm){

                return $classSubject->whereJsonContains('class_arm', $classArm->uuid);
            }
            elseif ($classSubject->class_section_id && ! $classSubject->class_section_category_id){
                return  $classSubject->class_section_id == $classArm->class_section_id;
            }

            return $classSubject->class_section_id == $classArm->class_section_id && $classSubject->class_section_category_id == $classArm->class_section_category_id;
        });


        $classSubjects = $classSubjects->whereNotIn('uuid', $studentSubjectIds);

        $classSubjects->load('subject');

        return view('Tenant.pages.student.subject.index', [
            'studentId'      => $student->uuid,
            'totalSubject'   => $totalSubject,
            'studentName'    => "{$student->first_name} {$student->last_name}",
            'classSubjects'  => collect($classSubjects)->values(),
            'studentSubject' => collect($studentSubject),
        ]);
    }

//    public function create(string $uuid)
//    {
//        $student = Student::query()->where('uuid', $uuid)->firstOrFail();
//
//        return view('Tenant.pages.student.subject.create', [
//            'studentId' => $student->uuid,
//        ]);
//    }

    public function store(string $uuid, Request $request)
    {
        $this->validate($request, [
            'subjects.*' => ['unique:school_subjects,subject_id'],
            'subjects'   => ['required', 'array','min:1']
        ]);


        $student = Student::query()->where('uuid', '=', $uuid)->first();

        if( ! $student->subjects ){

            (new CreateNewStudentSubjectAction())->execute($student, [
                'subjects' => $request->input('subjects'),
            ]);

            Session::flash('successFlash', 'Subject added successfully!!!');

            return back();
        }

        $student->subjects->subjects = collect($student->subjects->subjects)->merge($request->input('subjects'));

        $student->subjects->save();

        Session::flash('successFlash', 'Subject added successfully!!!');

        return back();
    }
}
