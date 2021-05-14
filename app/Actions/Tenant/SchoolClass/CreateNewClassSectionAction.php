<?php


namespace App\Actions\Tenant\SchoolClass;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionAction
{
    public function execute(Model $schoolClass, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return $schoolClass->classSection()->create($input);
    }
}
