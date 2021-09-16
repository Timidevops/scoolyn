<?php

namespace Tests\Feature\Tenant\Parent;

use App\Models\Tenant\StudentParent;
use App\Models\Tenant\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParentsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_parent_controller_is_stored()
    {
        $response = $this->post('parent', [
            'fullName' => 'john doe',
            'email' => 'john.doe@test.com',
        ]);

        $response->assertRedirect('/');

        $getParent = StudentParent::all()->first();
        $getUser = User::all()->first();

        $this->assertEquals('john doe', $getParent->full_name);
        $this->assertEquals('john.doe@test.com', $getUser->email);
        // assert that role name matches
        $this->assertEquals(User::PARENT_USER, $getUser->roles->pluck('name')[0]);
    }
}
