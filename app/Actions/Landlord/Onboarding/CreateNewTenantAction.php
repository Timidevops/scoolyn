<?php


namespace App\Actions\Landlord\Onboarding;


use App\Models\Tenant\ScoolynTenant;

class CreateNewTenantAction
{
    public function execute(array $input)
    {
        return ScoolynTenant::query()->create($input);
    }
}
