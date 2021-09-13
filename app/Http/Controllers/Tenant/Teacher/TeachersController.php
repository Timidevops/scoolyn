<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeachersController extends Controller
{
    public function index()
    {
        $teachers = Teacher::query()->get(['full_name', 'staff_id', 'uuid']);
        $teachers->load(['subjectTeacher', 'classArm']);

        return view('tenant.pages.teacher.teacher', [
            'totalTeachers' => Teacher::query()->count(),
            'teachers'      => collect($teachers),
        ]);
    }

    public function create()
    {
        return view('tenant.pages.teacher.addTeacher');
    }

    public function edit(string $uuid)
    {
        $teacher = Teacher::whereUuid($uuid);

        $classArms = $teacher->classArm;

        $classArms->load(['schoolClass', 'classSection', 'classSectionCategory']);

        $subjects = $teacher->subjectTeacher;

        //$subjects->load('');

        return view('Tenant.pages.teacher.edit', [
            'teacher'   => $teacher,
            'classArms' => $classArms,
            'subjects'  => $subjects,
        ]);
    }
}
