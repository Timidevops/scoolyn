<?php

namespace Tests\Feature\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassSubjectsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_class_subject_controller_is_stored()
    {
        $getSubject = Subject::factory()->make();
        $getClass = SchoolClass::factory()->make();

        (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        $getClassSection = ClassSection::all()->first();

        $response = $this->post('class/subject',[
            'subject' => $getSubject->uuid,
            'class' => $getClass->uuid,
            'classSection' => $getClassSection->uuid,
        ]);

        $response->assertRedirect('/');
        $getClassSubject = ClassSubject::all()->first();

        $this->assertEquals($getSubject->uuid, $getClassSubject->subject_id);
        $this->assertEquals($getClass->uuid, $getClassSubject->school_class_id);
        $this->assertEquals($getClassSection->uuid, $getClassSubject->class_section_id);
    }
}
