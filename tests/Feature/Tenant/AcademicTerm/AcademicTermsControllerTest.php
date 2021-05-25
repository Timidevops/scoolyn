<?php

namespace Tests\Feature\Tenant\AcademicTerm;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcademicTermsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_academic_term_controller_is_stored()
    {
        $response = $this->post('academic-term',[
            'termName' => 'third term'
        ]);

        $response->assertRedirect('/');
    }
}
