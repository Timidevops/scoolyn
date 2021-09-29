<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginsController extends Controller
{
    public function form()
    {
        return view('tenant.auth.login', [
            'schoolName' => Setting::schoolDetails()['schoolName'],
            'sideImage' => Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first(),
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        } else {
            Auth::attempt(['phone' => $request->email, 'password' => $request->password]);
        }

        if(! Auth::check()){
            return back()->with(['flashMessage' => "Invalid Login Credentials."])->withErrors('');
        }

        if(Auth::user()->isSuspended()){
            Auth::logout();
            return redirect()->back()->with(['flashMessage' => "Your account has been suspended. Please contact your school administrator."]);
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

}
