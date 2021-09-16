<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\Student;
use App\Models\Tenant\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query()->get();

        if($request->has('search')){
            $teachers = Student::where('first_name', 'like', '%'.$request->search . '%')
                ->orWhere('last_name', 'like', '%'.$request->search . '%')
                ->orWhere('matriculation_number', '=', $request->search)
                ->get();
        }

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
            'parents' => StudentParent::query()->get(['uuid', 'first_name', 'last_name']),
        ]);
    }

}
