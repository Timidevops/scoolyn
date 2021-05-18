<?php

namespace Tests\Unit\Tenant\Teacher;


use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\Subject\SubjectTeacher\CreateNewSubjectTeacherAction;
use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassTeacher;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use App\Models\Tenant\SubjectTeacher;
use App\Models\Tenant\Teacher;
use Tests\TestCase;

class CreateNewTeacherTest extends TestCase
{
    /**
     * @return void
     */
    public function test_teacher_is_created()
    {
        (new CreateNewTeacherAction())->execute([
            'full_name' => 'john doe',
        ]);

        $getTeacher = Teacher::all()->first();

        $this->assertEquals('john doe', $getTeacher->full_name);
    }

    public function test_that_class_teacher_is_created_as_class_section()
    {

        $getClass = SchoolClass::factory()->make();
        $getTeacher = Teacher::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewClassTeacherAction())->execute($getClassSection, [
            'teacher_id' => $getTeacher->uuid,
        ]);

        $getClassTeacher = ClassTeacher::all()->first();

        $this->assertEquals($getTeacher->uuid, $getClassTeacher->teacher_id);
    }

    public function test_that_class_teacher_is_created_as_class_section_category()
    {
        $getClass = SchoolClass::factory()->make();
        $getTeacher = Teacher::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        (new CreateNewClassTeacherAction())->execute($getClassSectionCategory, [
            'teacher_id' => $getTeacher->uuid,
        ]);

        $getClassTeacher = ClassTeacher::all()->first();

        $this->assertEquals($getTeacher->uuid, $getClassTeacher->teacher_id);
    }



    public function test_that_subject_teacher_is_created_as_class_section()
    {
        $getClass   = SchoolClass::factory()->make();
        $getTeacher = Teacher::factory()->make();
        $getSubject = Subject::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewSubjectTeacherAction())->execute($getClassSection, [
            'teacher_id' => $getTeacher->uuid,
            'subject_id' => $getSubject->uuid,
        ]);

        $getSubjectTeacher = SubjectTeacher::all()->first();

        $this->assertEquals($getTeacher->uuid, $getSubjectTeacher->teacher_id);
        $this->assertEquals($getSubject->uuid, $getSubjectTeacher->subject_id);
    }

    public function test_that_subject_teacher_is_created_as_class_section_category()
    {
        $getClass   = SchoolClass::factory()->make();
        $getTeacher = Teacher::factory()->make();
        $getSubject = Subject::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        (new CreateNewSubjectTeacherAction())->execute($getClassSectionCategory, [
            'teacher_id' => $getTeacher->uuid,
            'subject_id' => $getSubject->uuid,
        ]);

        $getSubjectTeacher = SubjectTeacher::all()->first();

        $this->assertEquals($getTeacher->uuid, $getSubjectTeacher->teacher_id);
        $this->assertEquals($getSubject->uuid, $getSubjectTeacher->subject_id);
    }
}
