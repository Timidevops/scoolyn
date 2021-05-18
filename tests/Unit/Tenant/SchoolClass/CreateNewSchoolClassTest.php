<?php

namespace Tests\Unit\Tenant\SchoolClass;


use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Tests\TestCase;

class CreateNewSchoolClassTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_that_school_class_is_created()
    {
        (new CreateNewSchoolClassAction())->execute([
            'class_name' => 'jss one'
        ]);

        $getClass = SchoolClass::all()->first();

        $this->assertEquals('jss one', $getClass->class_name);
        $this->assertEquals('jss-one', $getClass->slug);
    }

    public function test_that_class_section_is_created()
    {
        $getClass = (new CreateNewSchoolClassAction())->execute([
            'class_name' => 'jss one'
        ]);

        (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        $getClassSection = ClassSection::all()->first();

        $this->assertEquals('a', $getClassSection->section_name);
    }

    public function test_that_class_section_category_is_created()
    {
        $getClass = (new CreateNewSchoolClassAction())->execute([
            'class_name' => 'sss one'
        ]);

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        $this->assertEquals('a', $getClassSectionCategory->category_name);
        $this->assertEquals($getClassSection->uuid, $getClassSectionCategory->class_section_id);
    }

    public function test_that_class_subject_is_created()
    {
        $getSubject = Subject::factory()->make();
        $getClass = SchoolClass::factory()->make();

        (new CreateNewClassSubjectAction())->execute([
            'subject_id' => $getSubject->uuid,
            'school_class_id' => $getClass->uuid,
        ]);

        $getClassSubject = ClassSubject::all()->first();

        $this->assertEquals($getSubject->uuid, $getClassSubject->subject_id);
        $this->assertEquals($getClass->uuid, $getClassSubject->school_class_id);
    }

    public function test_that_class_subject_is_created_as_section()
    {
        $getSubject = Subject::factory()->make();
        $getClass = SchoolClass::factory()->make();

        (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        $getClassSection = ClassSection::all()->first();

        (new CreateNewClassSubjectAction())->execute([
            'subject_id' => $getSubject->uuid,
            'school_class_id' => $getClass->uuid,
            'class_section_id' => $getClassSection->uuid,
        ]);

        $getClassSubject = ClassSubject::all()->first();

        $this->assertEquals($getSubject->uuid, $getClassSubject->subject_id);
        $this->assertEquals($getClass->uuid, $getClassSubject->school_class_id);
        $this->assertEquals($getClassSection->uuid, $getClassSubject->class_section_id);
    }
}
