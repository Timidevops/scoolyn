<?php


namespace App\Actions\Tenant\Setting;


use App\Models\Tenant\Setting;

class SetCurrentAcademicCalendarAction
{
    public function execute(array $input)
    {
        $setting = Setting::query()->where('setting_name', '=', Setting::ACADEMIC_CALENDAR_SETTING)->first();

        if( ! $setting ){
          return  Setting::query()->create($input);
        }
        return $setting->update($input);
    }
}
