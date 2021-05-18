<?php

namespace Tests\Feature\Tenant\AcademicSession;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcademicSessionsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_that_academic_session_controller_is_stored()
    {

        $response = $this->post('/academic-session',[
            'session_name' => '2021/2022',
            'session_year' => '2021'
        ]);

        $response->assertRedirect('/');
    }
}
