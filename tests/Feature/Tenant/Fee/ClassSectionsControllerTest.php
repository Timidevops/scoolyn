<?php

namespace Tests\Feature\Tenant\Fee;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Models\Tenant\ClassFee;
use App\Models\Tenant\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassSectionsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_class_section_controller_fee_is_stored()
    {
        $getClass = SchoolClass::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        $response = $this->post('fee/class', [
            'classSection' => $getClassSection->uuid,
            'feeType' => 'id-9002',
        ]);

        $response->assertRedirect('/');
        $getClassSectionFee = ClassFee::all()->first();

        $this->assertEquals('id-9002', $getClassSectionFee->fee_structure_id);
        $this->assertEquals($getClassSection->uuid, $getClassSectionFee->class_section_id);
    }
}
