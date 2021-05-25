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
            'sectionName' => 'science',
            'categoryName' => 'a',
        ]);

        $response->assertRedirect('/');
        $getClass = SchoolClass::all()->first();

        $this->assertEquals('sss one', $getClass->class_name);
        $this->assertEquals('sss-one', $getClass->slug);

        $getClassSection = ClassSection::all()->first();

        $this->assertEquals('science', $getClassSection->section_name);

        $getClassSectionCategory = ClassSectionCategory::all()->first();

        $this->assertEquals('a', $getClassSectionCategory->category_name);
        $this->assertEquals($getClassSection->uuid, $getClassSectionCategory->class_section_id);
    }
}
