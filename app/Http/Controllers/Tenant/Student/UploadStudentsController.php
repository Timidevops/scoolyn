<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadStudentsController extends Controller
{
    public function create()
    {
        return view('Tenant.pages.student.uploadStudent');
    }
}
