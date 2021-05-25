<?php


namespace App\Actions\Tenant\SchoolClass;

use App\Models\Tenant\ClassSectionCategory;

class CreateNewClassSectionCategoryAction
{
    public function execute(array $input)
    {
      return ClassSectionCategory::query()->create($input);
    }
}
