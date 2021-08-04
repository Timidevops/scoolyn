<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    public function index()
    {

        if( Auth::user()->roles->contains( 'name', User::PARENT_USER) ){
            return view('Tenant.parentDomain.dashboard');
        }

        return view('Tenant.dashboard', [
            'totalTeachers' => Teacher::query()->count(),
            'totalStudents' => Student::query()->count(),
            'totalParents'  => Parents::query()->count(),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
