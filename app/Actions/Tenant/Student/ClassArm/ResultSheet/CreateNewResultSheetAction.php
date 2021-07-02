<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;


use App\Models\Tenant\AcademicResult;
use Ramsey\Uuid\Uuid;

class CreateNewResultSheetAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        return AcademicResult::query()->create($input);
    }
}
