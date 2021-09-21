<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Actions\Tenant\Teacher\DeleteTeacherAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TeachersController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::query()->get();
        if($request->has('search')){
            $teachers = Teacher::where('full_name', 'like', '%'.$request->search . '%')
                ->orWhere('staff_id', '=', $request->search)
                ->get();
        }
        $teachers->load(['subjectTeacher', 'classArm']);

        collect($teachers)->map(function ($teacher){
            $teacher['phone'] = $teacher->user->phone;
            return $teacher;
        });

        return view('tenant.pages.teacher.teacher', [
            'totalTeachers' => Teacher::query()->count(),
            'teachers' => collect($teachers),
        ]);
    }

    public function create()
    {
        return view('tenant.pages.teacher.addTeacher');
    }

    public function edit(string $uuid)
    {
        $teacher = Teacher::whereUuid($uuid);

        if ( ! $teacher ){
            abort(404);
        }

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

    public function delete(string $uuid)
    {
        $teacher = Teacher::whereUuid($uuid);

        if ( ! $teacher ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        (new DeleteTeacherAction)->execute($teacher);

        Session::flash('successFlash', 'Teacher removed successfully!!!');

        return redirect()->route('listTeacher');
    }
}
