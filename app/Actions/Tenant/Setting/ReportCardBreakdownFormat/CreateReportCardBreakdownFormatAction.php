<?php


namespace App\Actions\Tenant\Setting\ReportCardBreakdownFormat;


use App\Models\Tenant\Setting;

class CreateReportCardBreakdownFormatAction
{
    public function execute(array $input)
    {
        Setting::query()->create($input);
    }
}
