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
            ['name' => 'create a subject'],
            ['name' => 'read a subject'],
            ['name' => 'update a subject'],
            ['name' => 'delete a subject'],

            ['name' => 'create a subject teacher'],
            ['name' => 'read a subject teacher'],
            ['name' => 'update a teacher'],
            ['name' => 'delete a teacher'],

            ['name' => 'create a class arm'],
            ['name' => 'read a class arm'],
            ['name' => 'update a class arm'],
            ['name' => 'delete a class arm'],

            ['name' => 'create a class subject'],
            ['name' => 'read a class subject'],
            ['name' => 'update a class subject'],
            ['name' => 'delete a class subject'],

            ['name' => 'create a class teacher'],
            ['name' => 'read a class teacher'],
            ['name' => 'update a class teacher'],
            ['name' => 'delete a class teacher'],

            ['name' => 'create a user'],
            ['name' => 'read a user'],
            ['name' => 'update a user'],
            ['name' => 'delete a user'],

            ['name' => 'create a c.a format'],
            ['name' => 'read a c.a format'],
            ['name' => 'update a c.a format'],
            ['name' => 'delete a c.a format'],

            ['name' => 'create an academic broadsheet'],
            ['name' => 'read an academic broadsheet'],
            ['name' => 'update an academic broadsheet'],
            ['name' => 'delete an academic broadsheet'],

            ['name' => 'create an academic result'],
            ['name' => 'read an academic result'],
            ['name' => 'update an academic result'],
            ['name' => 'delete an academic result'],

            ['name' => 'create an academic grading format'],
            ['name' => 'read an academic grading format'],
            ['name' => 'update an academic grading format'],
            ['name' => 'delete an academic grading format'],

            ['name' => 'create a fee structure'],
            ['name' => 'read a fee structure'],
            ['name' => 'update a fee structure'],
            ['name' => 'delete a fee structure'],

            ['name' => 'create set academic session'],
            ['name' => 'read set academic session'],
            ['name' => 'update set academic session'],
            ['name' => 'delete set set academic session'],

            ['name' => 'update admission'],

            ['name' => 'update school details'],

            ['name' => 'create payment option'],
            ['name' => 'read payment option'],
            ['name' => 'update payment option'],
            ['name' => 'delete payment option'],

        ];

        foreach ($permissions as $permission)
        {
            Permission::create($permission);
        }
    }
}
