<?php


namespace App\Actions\Tenant\Setting\FrontendSetting;


use App\Actions\Tenant\File\UploadFileAction;
use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\Storage;

class UpdateFrontendSettingAction
{
    public function execute(array $input)
    {
        $setting = Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first();

        $file =  (new UploadFileAction)->execute([
            'file' => $input['file'],
            'fileName' => 'login_reset_password_image_',
        ]);

        if ( ! $setting ){
            Setting::query()->create([
                'setting_name' => Setting::FRONTEND_AUTH_IMAGE,
                'setting_value' => $file,
            ]);

            return;
        }

        Storage::disk('local')->delete($setting->setting_value);

        $setting->update([
            'setting_value' => $file
        ]);
    }
}
