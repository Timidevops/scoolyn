<?php

namespace Tests\Unit\Tenant\Student;


use App\Actions\Tenant\Student\StudentSubject\CreateNewStudentSubjectAction;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use App\Models\Tenant\Subject;
use Tests\TestCase;

class CreateNewStudentSubjectTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_student_subject_is_created()
    {
        $getStudent = Student::factory()->make();
        $getSubject = Subject::factory()->make();

        (new CreateNewStudentSubjectAction())->execute($getStudent,[
            'subjects' =>  [$getSubject->uuid],
        ]);

        $getStudentSubject = StudentSubject::all()->first();

        $this->assertEquals($getStudent->uuid, $getStudentSubject->student_id);
        $this->assertIsArray($getStudentSubject->subjects);
        $this->assertEquals($getSubject->uuid, $getStudentSubject->subjects[0]);
    }
}
