<?php


namespace App\Actions\Tenant\SchoolClass;


use App\Models\Tenant\ClassSectionType;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionTypeAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return ClassSectionType::query()->create($input);
    }
}
