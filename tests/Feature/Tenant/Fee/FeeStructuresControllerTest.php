<?php

namespace Tests\Feature\Tenant\Fee;

use App\Models\Tenant\FeeStructure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeeStructuresControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_fee_structure_controller_is_stored()
    {
        $response = $this->post('fee/format',[
            'name' => 'school fees',
            'amount' => 200000,
        ]);

        $response->assertRedirect('/');
        $getFeeStructure = FeeStructure::all()->first();

        $this->assertEquals('school fees', $getFeeStructure->name);
        $this->assertEquals(200000, $getFeeStructure->amount);
        $this->assertEquals('school-fees', $getFeeStructure->slug);
    }
}
