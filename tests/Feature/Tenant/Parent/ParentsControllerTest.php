<?php

namespace Tests\Feature\Tenant\Parent;

use App\Models\Tenant\Parents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParentsControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_parent_controller_is_stored()
    {
        $response = $this->post('parent', [
            'fullName' => 'john doe'
        ]);

        $response->assertRedirect('/');$getParent = Parents::all()->first();

        $this->assertEquals('john doe', $getParent->full_name);
    }
}
