<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordsController extends Controller
{
    public function edit()
    {
        return view('tenant.pages.setting.changePassword.edit');
    }
}
