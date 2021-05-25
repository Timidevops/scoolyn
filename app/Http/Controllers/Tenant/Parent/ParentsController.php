<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentsController extends Controller
{

    public function store(Request $request)
    {
        // create user
        $user = (new CreateUserAction())->execute([
            'name'     => $request->input('fullName'),
            'email'    => $request->input('email'),
            'password' => Hash::make(random_number(1,9,5)),
        ]);

        // assign student role
        $user->assignRole(User::PARENT_USER);

        (new CreateNewParentAction())->execute($user, camel_to_snake($request->except(['_token'])));

        // send welcome email
        $expiresAt = now()->addDay();
        $user->sendWelcomeNotification($expiresAt);

        return redirect('/');
    }
}
