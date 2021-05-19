<?php

namespace Tests\Feature\Tenant\Student;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Models\Tenant\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentsControllerTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_that_student_controller_is_stored()
    {
        $getParent = (new CreateNewParentAction())->execute([
            'full_name' => 'john doe',
        ]);

        $response = $this->post('student', [
            'matriculationNumber' => '101012',
            'firstName' => 'john',
            'lastName' => 'doe',
            'class' => 'id_class',
            'classSection' => 'id_classSection',
            'classSectionCategory' => 'id_classSectionCategory',
            'parent' => $getParent->uuid,
            //'parentFullName' => 'John Doe'
        ]);

        $response->assertRedirect('/');
        $getStudent = Student::all()->first();

        $this->assertEquals('101012', $getStudent->matriculation_number);
        $this->assertEquals('id_class', $getStudent->school_class_id);
        $this->assertEquals('id_classSection', $getStudent->class_section_id);
        $this->assertEquals('id_classSectionCategory', $getStudent->class_section_category_id);
    }
}
