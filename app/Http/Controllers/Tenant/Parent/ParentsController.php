<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\StudentParent;
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
            'totalParent' => StudentParent::query()->count(),
            'parents'     => StudentParent::query()->get(['uuid', 'first_name', 'last_name', 'email']),
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
        $this->validate($request, [
            'email' => ['unique:'.config('env.tenant.tenantConnection').'.parents,email', 'unique:'.config('env.tenant.tenantConnection').'.users,email'],
            'phoneNumber' => ['unique:'.config('env.tenant.tenantConnection').'.parents,phone_number', 'unique:'.config('env.tenant.tenantConnection').'.users,phone'],
        ]);

        // create user
        $password = "{$request->input('firstName')}_{$request->input('lastName')}";

        if( $request->input('phoneNumber') ){
            $password = $request->input('phoneNumber');
        }
        elseif ( $request->input('email') ){
            $password = $request->input('email');
        }

        $user = (new CreateUserAction())->execute([
            'name'     => "{$request->input('firstName')} {$request->input('lastName')}",
            'email'    => $request->input('email'),
            'password' => Hash::make($password),
            'phone'    => $request->input('phoneNumber'),
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

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_PARENT
        ]);

        Session::flash('successFlash', 'Parent added successfully!!!');

        return back();
    }
}
