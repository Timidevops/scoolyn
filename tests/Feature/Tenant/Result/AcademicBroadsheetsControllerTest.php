<?php

namespace Tests\Feature\Tenant\Result;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcademicBroadsheetsControllerTest extends TestCase
{
    /**basic feature test example.
     *
     * @return void
     */
    public function test_that_academic_broadsheet_controller_is_stored()
    {
        $getClass = SchoolClass::factory()->make();

        (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        $getClassSection = ClassSection::all()->first();

        (new CreateNewClassSectionCategoryAction())->execute($getClassSection, [
            'category_name' => 'a',
        ]);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        $response = $this->post('result/academic-broadsheet', [
            'classSection' => $getClassSection->uuid,
            'classSectionCategory' => $getClassSectionCategory->uuid,
            'subject' => 'id_subject',
            'teacher' => 'id_teacher',
            'broadsheet' => [
                'student_id' => [
                    'test_one' => '15',
                    'test_two' => '15',
                    'examination' => '70',
                ],
                'student_id_two' => [
                    'test_one' => '15',
                    'test_two' => '15',
                    'examination' => '70',
                ],
            ]
        ]);

        $response->assertRedirect('/');
        $getAcademicBroadsheet = AcademicBroadSheet::all()->first();

        $this->assertEquals($getClassSection->id, $getAcademicBroadsheet->schoolClass_id);
        $this->assertEquals('id_subject', $getAcademicBroadsheet->subject_id);
        $this->assertIsArray($getAcademicBroadsheet->meta);
        $this->assertCount(2,$getAcademicBroadsheet->meta);
        $this->assertCount(3,$getAcademicBroadsheet->meta['student_id']);
        $this->assertEquals('student_id', collect($getAcademicBroadsheet->meta)->keys()[0]);
    }
}
