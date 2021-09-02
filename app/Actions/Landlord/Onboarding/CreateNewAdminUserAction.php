<?php


namespace App\Actions\Landlord\Onboarding;


use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\User;

class CreateNewAdminUserAction
{
    public function execute(array $input)
    {
        $admin =  User::query()->create($input);

        $admin->assignRole(User::SUPER_ADMIN_USER);

        return $admin;
    }
}
