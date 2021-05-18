<?php

namespace Tests\Unit\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Tests\TestCase;

class CreateNewClassSubjectTest extends TestCase
{
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
