<?php


namespace App\Actions\Tenant\SchoolClass\ClassSubject;


use App\Models\Tenant\ClassSubject;
use Ramsey\Uuid\Uuid;

class CreateNewClassSubjectAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        ClassSubject::query()->create($input);
    }
}
