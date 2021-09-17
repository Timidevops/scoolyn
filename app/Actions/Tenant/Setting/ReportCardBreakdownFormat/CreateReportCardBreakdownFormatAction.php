<?php


namespace App\Actions\Tenant\Setting\ReportCardBreakdownFormat;


use App\Models\Tenant\ReportCardBreakdownFormat;
use Ramsey\Uuid\Uuid;

class CreateReportCardBreakdownFormatAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();

        ReportCardBreakdownFormat::query()->create($input);
    }
}
