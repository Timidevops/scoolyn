<?php

namespace Tests\Unit\Tenant\Student;


use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\Parents;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Student;
use Tests\TestCase;

class CreateNewStudentTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_student_is_created_as_class_section()
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

        $this->assertEquals('101012', $getStudent->matriculation_number);
        $this->assertEquals($getClass->uuid, $getStudent->school_class_id);
        $this->assertEquals($getClassSection->uuid, $getStudent->class_section_id);
    }

    public function test_student_is_created_as_class_section_category()
    {
        $getParent = Parents::factory()->make();
        $getClass = SchoolClass::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        (new CreateNewStudentAction())->execute($getParent, [
            'matriculation_number' => '101012',
            'first_name' => 'john',
            'last_name' => 'doe',
            'school_class_id' => $getClass->uuid,
            'class_section_id' => $getClassSection->uuid,
            'class_section_category_id' => $getClassSectionCategory->uuid,
        ]);

        $getStudent = Student::all()->first();

        $this->assertEquals('101012', $getStudent->matriculation_number);
        $this->assertEquals($getClass->uuid, $getStudent->school_class_id);
        $this->assertEquals($getClassSection->uuid, $getStudent->class_section_id);
        $this->assertEquals($getClassSectionCategory->uuid, $getStudent->class_section_category_id);

    }
}
