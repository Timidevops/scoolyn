<?php

namespace Tests\Feature\Tenant\Teacher;

use App\Models\Tenant\Teacher;
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
        ]);

        $response->assertRedirect('/');
        $getTeacher = Teacher::all()->first();

        $this->assertEquals('john doe', $getTeacher->full_name);
    }
}
