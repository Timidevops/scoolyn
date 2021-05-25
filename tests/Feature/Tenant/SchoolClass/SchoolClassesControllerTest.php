<?php

namespace Tests\Feature\Tenant\SchoolClass;

use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolClassesControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_school_class_controller_is_stored()
    {
        $response = $this->post('class', [
            'className' => 'sss one',
            'newSectionName' => 'science',
            'classSectionType' => 'classSectionTypeId',
            'categoryName' => 'categoryNameId',
            'newClassSectionCategoryType' => 'a'
        ]);

        $response->assertRedirect('/');
        $getClass = SchoolClass::all()->first();

        $this->assertEquals('sss one', $getClass->class_name);
        $this->assertEquals('sss-one', $getClass->slug);

        $this->assertEquals('science', $getClass->classSection->section_name);

        $getClassSection = ClassSection::all()->first();

        $this->assertEquals('a', $getClassSection->classSectionCategory->category_name);
//        $this->assertEquals($getClassSection->uuid, $getClassSectionCategory->class_section_id);
    }
}
