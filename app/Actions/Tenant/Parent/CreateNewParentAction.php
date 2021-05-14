<?php


namespace App\Actions\Tenant\Parent;


use App\Models\Tenant\Parents;

class CreateNewParentAction
{
    public function execute(array $input)
    {
        $input['uuid'] = $input;
        return Parents::query()->create($input);
    }
}
