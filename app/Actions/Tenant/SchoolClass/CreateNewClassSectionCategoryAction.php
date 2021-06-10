<?php


namespace App\Actions\Tenant\SchoolClass;

use App\Models\Tenant\ClassSectionCategory;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionCategoryAction
{
    public function execute(array $input)
    {
      $input['uuid'] = Uuid::uuid4();
      return ClassSectionCategory::query()->create($input);
    }
}
