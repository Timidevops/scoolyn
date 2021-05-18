<?php

namespace Tests\Unit\Tenant\Broadsheet;


use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\SchoolClass;
use Tests\TestCase;

class CreateNewBroadsheetTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_academic_broadsheet_is_created_as_section()
    {
        $getClass = SchoolClass::factory()->make();

        (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        $getClassSection = ClassSection::all()->first();

        (new CreateNewBroadsheetAction())->execute($getClassSection, [
            'subject_id' => 'id-99302',
            'teacher_id' => 'id-39203',
            'meta' => [
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
            ],
        ]);

        $getAcademicBroadsheet = AcademicBroadSheet::all()->first();

        $this->assertEquals($getClassSection->id, $getAcademicBroadsheet->schoolClass_id);
        $this->assertEquals('id-99302', $getAcademicBroadsheet->subject_id);
        $this->assertIsArray($getAcademicBroadsheet->meta);
        $this->assertCount(2,$getAcademicBroadsheet->meta);
        $this->assertCount(3,$getAcademicBroadsheet->meta['student_id']);
        $this->assertEquals('student_id', collect($getAcademicBroadsheet->meta)->keys()[0]);
    }

    public function test_that_academic_broadsheet_is_created_as_section_category()
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

        (new CreateNewBroadsheetAction())->execute($getClassSectionCategory, [
            'subject_id' => 'id-99302',
            'teacher_id' => 'id-39203',
            'meta' => [
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
            ],
        ]);

        $getAcademicBroadsheet = AcademicBroadSheet::all()->first();

        $this->assertEquals($getClassSection->id, $getAcademicBroadsheet->schoolClass_id);
        $this->assertEquals('id-99302', $getAcademicBroadsheet->subject_id);
        $this->assertIsArray($getAcademicBroadsheet->meta);
        $this->assertCount(2,$getAcademicBroadsheet->meta);
        $this->assertCount(3,$getAcademicBroadsheet->meta['student_id']);
        $this->assertEquals('student_id', collect($getAcademicBroadsheet->meta)->keys()[0]);
    }
}
