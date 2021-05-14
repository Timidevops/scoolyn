<?php


namespace App\Actions\Tenant\Teacher;


use App\Models\Tenant\Teacher;
use Ramsey\Uuid\Uuid;

class CreateNewTeacherAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return Teacher::query()->create($input);
    }
}
