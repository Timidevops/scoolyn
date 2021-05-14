<?php


namespace App\Actions\Tenant\Result\ContinuousAssessment;


use App\Models\Tenant\ContinuousAssessmentStructure;
use Ramsey\Uuid\Uuid;

class CreateNewCAStructureAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        ContinuousAssessmentStructure::query()->create($input);
    }
}
