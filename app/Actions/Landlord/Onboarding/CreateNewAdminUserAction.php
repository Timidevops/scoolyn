<?php


namespace App\Actions\Landlord\Onboarding;

use App\Models\Tenant\User;

class CreateNewAdminUserAction
{
    public function execute(array $input, bool $isSuperAdmin = true)
    {
        $admin =  User::query()->create($input);

        if ( ! $isSuperAdmin ){

            $admin->assignRole(User::ADMIN_USER);

            return  $admin;
        }

        $admin->assignRole(User::SUPER_ADMIN_USER);

        return $admin;
    }
}
