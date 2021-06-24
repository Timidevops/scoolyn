<?php


namespace App\Actions\Tenant\Result\AcademicGrading;


use App\Models\Tenant\AcademicGradingFormat;
use Ramsey\Uuid\Uuid;

class CreateNewGradingFormat
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        AcademicGradingFormat::query()->create($input);
    }
}
