<?php


namespace App\Actions\Tenant\Setting\ReportCardBreakdownFormat;


use App\Models\Tenant\Setting;

class UpdateReportCardBreakdownFormatSettingAction
{
    public function execute(array $input)
    {
        if ( Setting::getCurrentCardBreakdownFormat() == '' ){
            Setting::query()->create($input);
        }

        $setting = Setting::whereSettingName(Setting::REPORT_CARD_BREAKDOWN_FORMAT_SETTING)->first();

        $setting->update($input);
    }
}
