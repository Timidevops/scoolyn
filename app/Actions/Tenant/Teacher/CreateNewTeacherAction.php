<?php


namespace App\Actions\Tenant\Teacher;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewTeacherAction
{
    public function execute(Model $user, array $input): Model
    {
        $input['uuid'] = Uuid::uuid4();
        return $user->teacher()->create($input);
    }
}
