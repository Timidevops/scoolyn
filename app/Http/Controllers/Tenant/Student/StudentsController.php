<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use App\Models\Tenant\Student;
use App\Models\Tenant\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
        $students = Student::query()->get();

        $students->load(['parent']);

        $classArm = $students->map(function ($student){
            return $student->classArm;
        });

        $classArms = $classArm->load(['schoolClass', 'classSection', 'classSectionCategory']);

        return view('Tenant.pages.student.student', [
            'totalStudents' => Student::query()->count(),
            'students'      => $students,
            'classArm'      => $classArms,
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.student.addStudent', [
            'parents' => Parents::query()->get(['uuid', 'first_name', 'last_name']),
        ]);
    }

}
