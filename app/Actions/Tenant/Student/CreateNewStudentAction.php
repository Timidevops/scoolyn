<?php


namespace App\Actions\Tenant\Student;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewStudentAction
{
    public function execute(Model $parent, array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        return $parent->ward()->create($input);
    }
}
