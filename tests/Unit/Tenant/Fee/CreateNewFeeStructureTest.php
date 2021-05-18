<?php

namespace Tests\Unit\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewFeeStructureAction;
use App\Models\Tenant\FeeStructure;
use Tests\TestCase;

class CreateNewFeeStructureTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_fee_structure_is_created()
    {
        (new CreateNewFeeStructureAction())->execute([
            'name' => 'school fees',
            'amount' => 200000,
        ]);

        $getFeeStructure = FeeStructure::all()->first();

        $this->assertEquals('school fees', $getFeeStructure->name);
        $this->assertEquals(200000, $getFeeStructure->amount);
        $this->assertEquals('school-fees', $getFeeStructure->slug);
    }
}
