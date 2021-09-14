<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Actions\Tenant\Teacher\SuspendTeacherAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SuspendController extends Controller
{
    public function store(string $uuid)
    {
        $teacher = Teacher::whereUuid($uuid);

        if ( ! $teacher ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        //suspend user.
        (new SuspendTeacherAction)->execute($teacher);

        Session::flash('successFlash','Teacher access suspended successfully!!!');

        return back();

    }
}
