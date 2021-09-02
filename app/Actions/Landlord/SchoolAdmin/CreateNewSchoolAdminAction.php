<?php


namespace App\Actions\Landlord\SchoolAdmin;


use App\Models\Landlord\SchoolAdmin;

class CreateNewSchoolAdminAction
{
    public function execute(array $input)
    {
        return SchoolAdmin::query()->create($input);
    }
}
