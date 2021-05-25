<?php

namespace Tests\Feature\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassTeacher;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassTeachersControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_class_teacher_controller_is_stored()
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

        $response = $this->post('class/teacher', [
            'classSection' => $getClassSection->uuid,
            'classSectionCategory' => $getClassSectionCategory->uuid,
            'teacher' => $getTeacher->uuid,
        ]);

        $response->assertRedirect('/');
        $getClassTeacher = ClassTeacher::all()->first();

        $this->assertEquals($getTeacher->uuid, $getClassTeacher->teacher_id);
    }
}
