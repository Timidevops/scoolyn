<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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

        Role::create(['name' => User::SUPER_ADMIN_USER, 'guard_name' => 'web'])->givePermissionTo(Permission::all());
        Role::create(['name' => User::ADMIN_USER, 'guard_name' => 'web'])->givePermissionTo(Permission::query()->whereNotIn('name',[
            'read admin user',
            'create admin user',
            'update admin user',
            'delete admin user'
        ])->get());

        Role::create(['name' => User::SUBJECT_TEACHER_USER, 'guard_name' => 'web'])->givePermissionTo([
            'create an academic broadsheet',
            'read an academic broadsheet',
            'update an academic broadsheet',
            'delete an academic broadsheet'
        ]);

        Role::create(['name' => User::CLASS_TEACHER_USER, 'guard_name' => 'web'])->givePermissionTo([
            'create an academic result',
            'read an academic result',
            'update an academic result',
            'delete an academic result'
        ]);
        //Role::create(['name' => User::STUDENT_USER]);
        Role::create(['name' => User::PARENT_USER, 'guard_name' => 'web']);
    }
}
