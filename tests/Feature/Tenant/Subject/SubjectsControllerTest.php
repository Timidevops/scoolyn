<?php

namespace Tests\Feature\Tenant\Subject;

use App\Models\Tenant\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_subject_controller_is_stored()
    {
        $response = $this->post('subject', [
            'subjectName' => 'further maths',
        ]);

        $response->assertRedirect('/');

        $getSubject = Subject::all()->first();

        $this->assertEquals('further maths', $getSubject->subject_name);
        $this->assertEquals('further-maths', $getSubject->slug);
    }
}
