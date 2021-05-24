<?php


namespace App\Actions\Tenant\User;


use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateUserAction
{
    public function execute(array $input) : Model
    {
        $input['uuid'] = Uuid::uuid4();
        return User::query()->create($input);

    }
}
