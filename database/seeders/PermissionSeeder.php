<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['name' => 'create a subject', 'guard_name' => 'web'],
            ['name' => 'read a subject', 'guard_name' => 'web'],
            ['name' => 'update a subject', 'guard_name' => 'web'],
            ['name' => 'delete a subject', 'guard_name' => 'web'],

            ['name' => 'create a subject teacher', 'guard_name' => 'web'],
            ['name' => 'read a subject teacher', 'guard_name' => 'web'],
            ['name' => 'update a teacher', 'guard_name' => 'web'],
            ['name' => 'delete a teacher', 'guard_name' => 'web'],

            ['name' => 'create a class arm', 'guard_name' => 'web'],
            ['name' => 'read a class arm', 'guard_name' => 'web'],
            ['name' => 'update a class arm', 'guard_name' => 'web'],
            ['name' => 'delete a class arm', 'guard_name' => 'web'],

            ['name' => 'create a class subject', 'guard_name' => 'web'],
            ['name' => 'read a class subject', 'guard_name' => 'web'],
            ['name' => 'update a class subject', 'guard_name' => 'web'],
            ['name' => 'delete a class subject', 'guard_name' => 'web'],

            ['name' => 'create a class teacher', 'guard_name' => 'web'],
            ['name' => 'read a class teacher', 'guard_name' => 'web'],
            ['name' => 'update a class teacher', 'guard_name' => 'web'],
            ['name' => 'delete a class teacher', 'guard_name' => 'web'],

            ['name' => 'create a user', 'guard_name' => 'web'],
            ['name' => 'read a user', 'guard_name' => 'web'],
            ['name' => 'update a user', 'guard_name' => 'web'],
            ['name' => 'delete a user', 'guard_name' => 'web'],

            ['name' => 'create a c.a format', 'guard_name' => 'web'],
            ['name' => 'read a c.a format', 'guard_name' => 'web'],
            ['name' => 'update a c.a format', 'guard_name' => 'web'],
            ['name' => 'delete a c.a format', 'guard_name' => 'web'],

            ['name' => 'create an academic broadsheet', 'guard_name' => 'web'],
            ['name' => 'read an academic broadsheet', 'guard_name' => 'web'],
            ['name' => 'update an academic broadsheet', 'guard_name' => 'web'],
            ['name' => 'delete an academic broadsheet', 'guard_name' => 'web'],

            ['name' => 'create an academic result', 'guard_name' => 'web'],
            ['name' => 'read an academic result', 'guard_name' => 'web'],
            ['name' => 'update an academic result', 'guard_name' => 'web'],
            ['name' => 'delete an academic result', 'guard_name' => 'web'],

            ['name' => 'create an academic grading format', 'guard_name' => 'web'],
            ['name' => 'read an academic grading format', 'guard_name' => 'web'],
            ['name' => 'update an academic grading format', 'guard_name' => 'web'],
            ['name' => 'delete an academic grading format', 'guard_name' => 'web'],

            ['name' => 'create a fee structure', 'guard_name' => 'web'],
            ['name' => 'read a fee structure', 'guard_name' => 'web'],
            ['name' => 'update a fee structure', 'guard_name' => 'web'],
            ['name' => 'delete a fee structure', 'guard_name' => 'web'],

            ['name' => 'create set academic session', 'guard_name' => 'web'],
            ['name' => 'read set academic session', 'guard_name' => 'web'],
            ['name' => 'update set academic session', 'guard_name' => 'web'],
            ['name' => 'delete set set academic session', 'guard_name' => 'web'],

            ['name' => 'update admission', 'guard_name' => 'web'],

            ['name' => 'update school details', 'guard_name' => 'web'],

            ['name' => 'create payment option', 'guard_name' => 'web'],
            ['name' => 'read payment option', 'guard_name' => 'web'],
            ['name' => 'update payment option', 'guard_name' => 'web'],
            ['name' => 'delete payment option', 'guard_name' => 'web'],

        ];

        foreach ($permissions as $permission)
        {
            Permission::create($permission);
        }
    }
}
