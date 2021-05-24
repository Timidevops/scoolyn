<?php

namespace Tests\Unit\Tenant\Parent;


use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Models\Tenant\Parents;
use App\Models\Tenant\User;
use Tests\TestCase;

class CreateNewParentTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_that_parent_is_created()
    {
        $getUser = User::factory()->make();
        (new CreateNewParentAction())->execute($getUser,[
            'full_name' => 'john doe',
            'email' => 'john.doe@test.com',
        ]);

        $getParent = Parents::all()->first();

        $this->assertEquals('john doe', $getParent->full_name);
    }
}
