<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\FeeStructure;
use Ramsey\Uuid\Uuid;

class CreateNewFeeStructureAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        FeeStructure::query()->create($input);
    }
}
