<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Rules\Tenant\CheckIfNewPasswordIsSameAsOld;
use App\Rules\Tenant\CheckIfOldPasswordIsCorrect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ChangePasswordsController extends Controller
{
    public function update(Request $request)
    {
        $this->validateForm($request->all());

        Auth::user()->password = Hash::make('newPassword');

        Auth::user()->save();

        Session::flash('successFlash', 'Password changed successfully!!!');

        return back();
    }

    private function validateForm(array $request)
    {
        Validator::validate($request, [
            'currentPassword' => ['required', new CheckIfOldPasswordIsCorrect()],
            'newPassword' => ['required', new CheckIfNewPasswordIsSameAsOld(), 'confirmed', 'min:8'],
        ]);

    }
}
