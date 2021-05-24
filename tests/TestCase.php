<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() : void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --path=database/migrations/tenants --database=testDB --seed');
        Artisan::call('db:seed --class=RoleSeeder');
    }

    public function tearDown() : void
    {
        //Artisan::call('migrate:reset --path=database/migrations/tenants --database=testDB ');
        //parent::tearDown();
    }

}
