<?php


namespace App\Actions\Tenant\Setting\SchoolLogo;


use App\Models\Tenant\Setting;

class UpdateSchoolLogoAction
{
    public function execute(array $input)
    {
        $setting = Setting::getSchoolLogo();

        //@todo upload school logo $input['schoolLogo']
        $logo = '';

        if( ! $setting ){
            Setting::query()->create([
                'setting_name' => Setting::SCHOOL_LOGO,
                'setting_value' => $logo,
            ]);

            return;
        }

        $setting = Setting::whereSettingName(Setting::SCHOOL_LOGO)->first();

        $setting->update([
            'setting_value' => $logo,
        ]);
    }
}
