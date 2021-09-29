<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use App\Notifications\Tenant\User\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgetPasswordsController extends Controller
{
    public function create()
    {
        return view('tenant.auth.forgotPassword', [
            'schoolName' => Setting::schoolDetails()['schoolName'],
            'sideImage' => Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'exists:'.config('env.tenant.tenantConnection').'.users,email'],
        ]);

        $user = User::query()->where('email', $request->input('email'))->first();

        $user->notify(new ResetPasswordNotification(Password::createToken($user)));

        Session::flash('successFlash', 'Reset password link sent successfully!!!');

        return back();

    }

    public function edit(Request $request)
    {
        return view('tenant.auth.resetPassword', [
            'schoolName' => Setting::schoolDetails()['schoolName'],
            'token' => $request->input('token'),
            'sideImage' => Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:8', 'confirmed'],
            'token' => ['required'],
        ]);

        $status = Password::reset($request->only([
            'email',
            'password',
            'password_confirmation',
            'token',
        ]), function ($user, $password){

            $user->forceFill([
                'password' => Hash::make($password)
            ]);

            $user->save();

            event(new PasswordReset($user));
        });

        if ( $status != Password::PASSWORD_RESET ){

            Session::flash('errorFlash', 'Error changing password');

            return back();
        }

        Session::flash('successFlash', 'Password changed successfully!!!');

        return redirect()->route('login');
    }
}
