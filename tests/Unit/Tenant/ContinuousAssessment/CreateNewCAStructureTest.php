<?php

namespace Tests\Unit\Tenant\ContinuousAssessment;


use App\Actions\Tenant\Result\ContinuousAssessment\CreateNewCAStructureAction;
use App\Models\Tenant\ContinuousAssessmentStructure;
use Tests\TestCase;

class CreateNewCAStructureTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_ca_structure_is_created()
    {
        (new CreateNewCAStructureAction())->execute([
            'name' => 'default',
            'meta' => [
                'test_one' => '15',
                'test_two' => '15',
                'examination' => '70',
            ],
        ]);

        $getCAStructure = ContinuousAssessmentStructure::all()->first();

        $this->assertEquals('default', $getCAStructure->name);
        $this->assertIsArray($getCAStructure->meta);
        $this->assertEquals('15', $getCAStructure->meta['test_one']);
        $this->assertEquals('examination', collect($getCAStructure->meta)->keys()[2]);
    }
}
