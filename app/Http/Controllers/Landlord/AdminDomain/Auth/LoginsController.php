<?php

namespace App\Http\Controllers\Landlord\AdminDomain\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginsController extends Controller
{
    public function form()
    {
        return view('Landlord.adminDomain.pages.login.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        if ( ! Auth::guard('admin')->attempt($request->only(['email', 'password'])) ){

            Session::flash('errorFlash', 'Wrong email or password');

            return back();
        }

        return redirect()->route('landlordDashboard');
    }

}
