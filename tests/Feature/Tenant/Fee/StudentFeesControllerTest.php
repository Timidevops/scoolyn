<?php

namespace Tests\Feature\Tenant\Fee;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Models\Tenant\Parents;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentFeesControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_student_fee_controller_is_stored()
    {
        $getParent = Parents::factory()->make();
        $getClass = SchoolClass::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewStudentAction())->execute($getParent, [
            'matriculation_number' => '101012',
            'first_name' => 'john',
            'last_name' => 'doe',
            'school_class_id' => $getClass->uuid,
            'class_section_id' => $getClassSection->uuid,
        ]);

        $getStudent = Student::all()->first();

        $response = $this->post('fee/student',[
            'student' => $getStudent->uuid,
            'feeType' => 'id-993'
        ]);

        $response->assertRedirect('/');
        $getStudentFee = StudentFee::all()->first();

        $this->assertEquals('id-993', $getStudentFee->fee_structure_id);
        $this->assertEquals($getStudent->uuid, $getStudentFee->student_id);
    }
}
