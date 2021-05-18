<?php


namespace App\Actions\Tenant\Parent;


use App\Models\Tenant\Parents;
use Ramsey\Uuid\Uuid;

class CreateNewParentAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return Parents::query()->create($input);
    }
}
