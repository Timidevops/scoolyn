<?php

namespace Tests\Feature\Tenant\Student;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentSubjectsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_student_subject_controller_is_stored()
    {
        $getParent = StudentParent::factory()->make();
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


        $response = $this->post('student/subject', [
            'student' => $getStudent->uuid,
            'subjects' => ['1','2','3','4']
        ]);

        $response->assertRedirect('/');
        $getStudentSubject = StudentSubject::all()->first();

        $this->assertEquals($getStudent->uuid, $getStudentSubject->student_id);
        $this->assertIsArray($getStudentSubject->subjects);
        $this->assertEquals('1', $getStudentSubject->subjects[0]);
    }
}
