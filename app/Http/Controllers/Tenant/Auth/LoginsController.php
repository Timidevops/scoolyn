<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginsController extends Controller
{
    public function form()
    {
        return view('Tenant.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ]);

        if( ! Auth::attempt($request->only(['email', 'password'])) ){
            return back()->withErrors('');
        }

        return redirect()->route('dashboard');
    }

}
