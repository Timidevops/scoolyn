<?php

namespace Tests\Unit\Tenant\Fee;


use App\Actions\Tenant\Fee\CreateNewClassSectionFeeAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Models\Tenant\ClassFee;
use Tests\TestCase;

class CreateNewClassSectionFeeTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_class_section_fee_is_created()
    {
        $getClass = (new CreateNewSchoolClassAction())->execute([
            'class_name' => 'sss one'
        ]);

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        (new CreateNewClassSectionFeeAction())->execute($getClassSection, [
            'fee_structure_id' => 'id-9002',
        ]);

        $getClassSectionFee = ClassFee::all()->first();

        $this->assertEquals('id-9002', $getClassSectionFee->fee_structure_id);
        $this->assertEquals($getClassSection->uuid, $getClassSectionFee->class_section_id);
    }
}
