<?php


namespace App\Actions\Tenant\SchoolClass;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionCategoryAction
{
    public function execute(Model $classSection, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $classSection->classSectionCategory()->create($input);
    }
}
