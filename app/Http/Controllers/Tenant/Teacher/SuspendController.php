<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Actions\Tenant\User\SuspendUserAction;
use App\Actions\Tenant\User\UnSuspendUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Teacher;
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
        (new SuspendUserAction())->execute($teacher);

        Session::flash('successFlash','Teacher access suspended successfully!!!');

        return back();

    }
    public function unSuspend(string $uuid)
    {
        $teacher = Teacher::whereUuid($uuid);

        if ( ! $teacher ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        //suspend user.
        (new UnSuspendUserAction())->execute($teacher);

        Session::flash('successFlash','Teacher access unsuspended successfully!!!');

        return back();

    }
}
