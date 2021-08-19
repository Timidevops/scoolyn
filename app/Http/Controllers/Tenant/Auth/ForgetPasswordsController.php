<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use App\Notifications\Tenant\User\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgetPasswordsController extends Controller
{
    public function create()
    {
        //@todo return view

        $this->store([]);
    }

    public function store( $request)
    {
        //@todo validate request

        //@todo get user
        $user = User::find(1);//User::query()->where('email', $request->input('email'))->first();

        //$user->notify(new ResetPasswordNotification(Password::createToken($user)));

    }

    public function edit(Request $request)
    {
        //@todo return view
        dd('form');
    }

    public function update(Request $request)
    {
        //@todo validate request

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

        //@todo redirect back...
    }
}
