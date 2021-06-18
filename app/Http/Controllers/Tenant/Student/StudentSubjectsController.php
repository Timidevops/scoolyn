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

        $studentSubject = [];
        $totalSubject   = 0;

        if ($student->subjects){

            $studentSubject = $this->getStudentSubject($student->subjects->subjects);

            $totalSubject   = count($studentSubject);
        }

        $classSubjects = ClassSubject::query()
            ->where('school_class_id', $student->school_class_id)
            ->orWhere('class_section_id', $student->class_section_id)
            ->orWhere('class_section_category_id', $student->class_section_category_id)->get();

        $classSubjects->load('subject');

        return view('Tenant.pages.student.subject.index', [
            'studentId'      => $student->uuid,
            'totalSubject'   => $totalSubject,
            'studentName'    => "{$student->first_name} {$student->last_name}",
            'classSubjects'  => $classSubjects,
            'studentSubject' => collect($studentSubject),
        ]);
    }

    private function getStudentSubject(array $classSubjectId)
    {
        $studentClass = [];

        for( $int = 0; $int < count($classSubjectId); $int++ ){

            $classSubject = ClassSubject::query()->where('uuid', $classSubjectId[$int])->first();

            $studentClass [] = [
                'uuid'         => $classSubject->subject->uuid,
                'subject_name' => $classSubject->subject->subject_name,
            ];
        }

        return $studentClass;
    }

    public function create(string $uuid)
    {
        $student = Student::query()->where('uuid', $uuid)->firstOrFail();

        return view('Tenant.pages.student.subject.create', [
            'studentId' => $student->uuid,
        ]);
    }

    public function store(Request $request, string $uuid)
    {
        $student = Student::query()->where('uuid', '=', $uuid)->first();

        (new CreateNewStudentSubjectAction())->execute($student, [
            'subjects' => $request->input('subjects'),
        ]);

        return back();
    }
}
