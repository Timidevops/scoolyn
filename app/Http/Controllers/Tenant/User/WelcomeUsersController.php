<?php

namespace App\Http\Controllers\Tenant\User;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Spatie\WelcomeNotification\WelcomeController;

class WelcomeUsersController extends WelcomeController
{
    public function create()
    {
        dd('here');
    }

    public function store(Request $request, User $user)
    {
        $this->savePassword($request, $user);
    }
}
