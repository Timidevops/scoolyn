<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UploadParentsController extends Controller
{
    public function create()
    {
        return view('tenant.pages.parent.uploadParent');
    }
}
