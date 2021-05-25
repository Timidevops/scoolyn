<?php

namespace Tests\Feature\Tenant\Teacher;

use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeachersControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_teacher_controller_is_stored()
    {
        $response = $this->post('teacher', [
            'fullName' => 'john doe',
            'staffId' => 'staffId',
            'email' => 'john.doe@test.com'
        ]);

        $response->assertRedirect('/');
        $getTeacher = Teacher::all()->first();

        $getUser = User::all()->first();

        $this->assertEquals('john doe', $getTeacher->full_name);
        $this->assertEquals('john.doe@test.com', $getUser->email);
        $this->assertEquals(User::TEACHER_USER, $getUser->roles->pluck('name')[0]);

    }
}
