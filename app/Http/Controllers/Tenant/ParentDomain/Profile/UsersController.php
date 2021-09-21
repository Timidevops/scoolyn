<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Profile;

use App\Http\Controllers\Controller;
use App\Models\Tenant\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function single()
    {
        return view('Tenant.parentDomain.profile.index', [
            'parent' => Auth::user()->parent,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'phoneNumber' => ['required'],
            'address' => ['required']
        ]);

        $user =  Auth::user()->parent;

        $user->update(camel_to_snake($request->only(['phoneNumber', 'address'])));

        Session::flash('successFlash', 'Profile updated successfully!!!');

        return back();

    }
}
