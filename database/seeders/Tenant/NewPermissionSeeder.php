<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class NewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'read admission automation', 'guard_name' => 'web'],

            ['name' => 'read admin user', 'guard_name' => 'web'],
            ['name' => 'create admin user', 'guard_name' => 'web'],
            ['name' => 'update admin user', 'guard_name' => 'web'],
            ['name' => 'delete admin user', 'guard_name' => 'web'],

            ['name' => 'create report card assessment format', 'guard_name' => 'web'],
            ['name' => 'read report card assessment format', 'guard_name' => 'web'],
            ['name' => 'update report card assessment format', 'guard_name' => 'web'],
            ['name' => 'delete report card assessment format', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission)
        {
            Permission::create($permission);
        }
    }
}
