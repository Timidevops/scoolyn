<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Student\StudentSubject\CreateNewStudentSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

class StudentSubjectsController extends Controller
{
    public function store(Request $request)
    {
        $student = Student::query()->where('uuid', '=', $request->input('student'))->first();

        (new CreateNewStudentSubjectAction())->execute($student, [
            'subjects' => $request->input('subjects'),
        ]);

        return redirect('/');
    }
}
