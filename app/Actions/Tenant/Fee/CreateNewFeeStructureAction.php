<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\FeeStructure;
use Ramsey\Uuid\Uuid;

class CreateNewFeeStructureAction
{
    public function execute(string $schoolFeeId, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $input['school_fees_id'] = $schoolFeeId;
        FeeStructure::query()->create($input);
    }
}
