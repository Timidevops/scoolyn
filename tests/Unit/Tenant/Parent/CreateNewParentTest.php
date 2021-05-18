<?php

namespace Tests\Unit\Tenant\Parent;


use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Models\Tenant\Parents;
use Tests\TestCase;

class CreateNewParentTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_that_parent_is_created()
    {
        (new CreateNewParentAction())->execute([
            'full_name' => 'john doe',
        ]);

        $getParent = Parents::all()->first();

        $this->assertEquals('john doe', $getParent->full_name);
    }
}
