<?php

namespace App\Http\Controllers\Tenant\AdminUser;

use App\Actions\Landlord\Onboarding\CreateNewAdminUserAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;

class AdminsController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.adminUser.index', [
            'users' => User::role(User::ADMIN_USER)->get(),
            'totalUsers' => User::role(User::ADMIN_USER)->count(),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.adminUser.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', 'unique:'.config('env.tenant.tenantConnection').'.users,email'],
        ]);

        (new CreateNewAdminUserAction())->execute([
            'uuid' => Uuid::uuid4(),
            'email' => $request->input('email'),
            'name' => $request->input('name') ?? 'Administrator',
            'password' => Hash::make('password'),
        ], false);

        //@todo welcome email...

        Session::flash('successFlash', 'Admin added successfully!!!');

        return back();
    }

    public function edit(string $uuid)
    {
        $admin = User::query()->where('uuid', $uuid)->firstOrFail();

        return view('Tenant.pages.adminUser.edit');
    }

    public function update(string $uuid, Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        $admin = $admin = User::query()->where('uuid', $uuid)->first();

        if ( ! $admin ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        Session::flash('successFlash', 'Admin updated successfully!!!');

        return back();
    }
}
