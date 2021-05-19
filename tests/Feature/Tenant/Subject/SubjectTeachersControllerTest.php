<?php

namespace Tests\Feature\Tenant\Subject;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\SubjectTeacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectTeachersControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_subject_teacher_controller_is_stored()
    {
        $getClass = SchoolClass::factory()->make();
        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        $response = $this->post('subject/teacher', [
            'teacher' => 'id-teacher',
            'subject' => 'id-subject',
            'classSection' => $getClassSection->uuid,
            'classSectionCategory' => $getClassSectionCategory->uuid,
        ]);

        $response->assertRedirect('/');

        $getSubjectTeacher = SubjectTeacher::all()->first();

        $this->assertEquals('id-teacher', $getSubjectTeacher->teacher_id);
        $this->assertEquals('id-subject', $getSubjectTeacher->subject_id);
    }
}
