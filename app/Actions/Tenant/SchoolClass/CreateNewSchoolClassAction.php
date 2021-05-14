<?php


namespace App\Actions\Tenant\SchoolClass;


use App\Models\Tenant\SchoolClass;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolClassAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        return SchoolClass::query()->create($input);
    }
}
