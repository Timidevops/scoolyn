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
        return view('Tenant.auth.login', [
            'schoolName' => Setting::schoolDetails()['schoolName'],
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', 'exists:'.config('env.tenant.tenantConnection').'.users,email'],
            'password' => ['required'],
        ]);

        if( ! Auth::attempt($request->only(['email', 'password'])) ){
            return back()->withErrors('');
        }

        return redirect()->route('dashboard');
    }

}
