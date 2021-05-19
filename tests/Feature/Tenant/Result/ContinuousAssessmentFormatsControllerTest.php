<?php

namespace Tests\Feature\Tenant\Result;

use App\Models\Tenant\ContinuousAssessmentStructure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContinuousAssessmentFormatsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_continuous_assessment_format_is_stored()
    {
        $response = $this->post('result/continuous-assessment-format',[
            //'name' => 'default',
            'format' => [
                'test_one' => '15',
                'test_two' => '15',
                'examination' => '70',
            ],
        ]);

        $response->assertRedirect('/');
        $getCAStructure = ContinuousAssessmentStructure::all()->first();

        $this->assertEquals('default_', $getCAStructure->name);
        $this->assertIsArray($getCAStructure->meta);
        $this->assertEquals('15', $getCAStructure->meta['test_one']);
        $this->assertEquals('examination', collect($getCAStructure->meta)->keys()[2]);
    }
}
