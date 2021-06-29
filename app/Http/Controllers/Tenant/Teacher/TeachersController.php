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
        $teachers->load(['schoolClassByClassTeacher']);

        return view('tenant.pages.teacher.teacher', [
            'totalTeachers' => Teacher::query()->count(),
            'teachers'      => collect($teachers),
        ]);
    }

    public function create()
    {
        return view('tenant.pages.teacher.addTeacher');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = (new CreateUserAction())->execute([
            'name'      => $request->input('fullName'),
            'email'     => $request->input('email'),
            'password'  => Hash::make(random_number(1,9,5)),
        ]);

        // assign teacher role
        $user->assignRole(User::TEACHER_USER);

        (new CreateNewTeacherAction())->execute($user, camel_to_snake($request->only(['fullName', 'staffId', 'email'])));

        //@todo send welcome email
//        $expiresAt = now()->addDay();
//        $user->sendWelcomeNotification($expiresAt);

        return back();
    }
}
