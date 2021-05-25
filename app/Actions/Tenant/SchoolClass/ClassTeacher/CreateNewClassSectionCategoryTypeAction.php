<?php


namespace App\Actions\Tenant\SchoolClass\ClassTeacher;


use App\Models\Tenant\ClassSectionCategoryType;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionCategoryTypeAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return ClassSectionCategoryType::query()->create($input);
    }
}
