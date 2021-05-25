<?php


namespace App\Actions\Tenant\Parent;


use App\Models\Tenant\Parents;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewParentAction
{
    public function execute(Model $user, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return $user->parent()->create($input);
    }
}
