<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => User::SUPER_ADMIN_USER]);
        Role::create(['name' => User::ADMIN_USER]);
        Role::create(['name' => User::TEACHER_USER]);
        Role::create(['name' => User::STUDENT_USER]);
    }
}
