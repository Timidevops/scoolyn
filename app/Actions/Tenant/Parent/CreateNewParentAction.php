<?php


namespace App\Actions\Tenant\Parent;


use App\Models\Tenant\StudentParent;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewParentAction
{
    public function execute(Model $user, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $input['code'] = random_number(0,9,7);
        return $user->parent()->create($input);
    }
}
