<?php


namespace App\Actions\Tenant\Setting\SchoolLogo;


use App\Actions\Tenant\File\UploadFileAction;
use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\Storage;

class UpdateSchoolLogoAction
{
    public function execute(array $input)
    {
        $setting = Setting::getSchoolLogo();

        //upload school logo
        $logo = (new UploadFileAction())->execute([
            'file' => $input['file'],
            'fileName' => 'school_logo_',
        ]);

        if( ! $setting ){
            Setting::query()->create([
                'setting_name' => Setting::SCHOOL_LOGO,
                'setting_value' => $logo,
            ]);

            return;
        }

        $setting = Setting::whereSettingName(Setting::SCHOOL_LOGO)->first();

        Storage::disk('local')->delete($setting->setting_value);

        $setting->update([
            'setting_value' => $logo,
        ]);
    }
}
