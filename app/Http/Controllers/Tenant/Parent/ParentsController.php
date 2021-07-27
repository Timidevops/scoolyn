<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use App\Models\Tenant\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ParentsController extends Controller
{

    public function index()
    {
        return view('tenant.pages.parent.parent', [
            'totalParent' => Parents::query()->count(),
            'parents'     => Parents::query()->get(['uuid', 'first_name', 'last_name', 'email']),
        ]);
    }

    public function create()
    {
        return view('tenant.pages.parent.addParent');
    }

    /**
     * @param Request $request
     * @return mixed | RedirectResponse
     */
    public function store(Request $request)
    {
        // create user
        $user = (new CreateUserAction())->execute([
            'name'     => "{$request->input('firstName')} {$request->input('lastName')}",
            'email'    => $request->input('email'),
            'password' => Hash::make(random_number(1,9,5)),
        ]);

        // assign student role
        $user->assignRole(User::PARENT_USER);

        $parent = (new CreateNewParentAction())->execute($user, camel_to_snake($request->except(['_token', 'indirect'])));

        //@todo send welcome email
        //$expiresAt = now()->addDay();
        //$user->sendWelcomeNotification($expiresAt);

        if( $request['indirect'] ){
            return $parent;
        }

        Session::flash('successFlash', 'Parent added successfully!!!');

        return back();
    }
}
