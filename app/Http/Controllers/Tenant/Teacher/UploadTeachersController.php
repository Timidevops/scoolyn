<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UploadTeachersController extends Controller
{
    public function create()
    {
        $classSubjects = ClassSubject::where('teacher_id', NULL)->get();
        if($classSubjects->isEmpty()){
            Session::flash('errorFlash', 'You need to add subjects to classes before proceeding.');
            return redirect()->route('listClass');
        }
        return view('tenant.pages.teacher.uploadTeacher');
    }
}
