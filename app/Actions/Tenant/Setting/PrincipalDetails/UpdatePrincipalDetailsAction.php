<?php


namespace App\Actions\Tenant\Setting\PrincipalDetails;


use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\Storage;

class UpdatePrincipalDetailsAction
{
    public function execute(array $input)
    {
        $setting = Setting::getSchoolPrincipal();

        //@todo upload signature $input['principalSignature']
        $signature = (new UploadPrincipalSignatureAction())->execute($input['principalSignature']);

        if ( ! $setting ){
            Setting::query()->create([
                'setting_name' => Setting::PRINCIPAL_INFO,
                'meta' => [
                    'principal_name' => $input['principalName'],
                    'principal_signature' => $signature,
                ],
            ]);

            return;
        }

        $setting = Setting::whereSettingName(Setting::PRINCIPAL_INFO)->first();

        Storage::disk('local')->delete($setting['meta']['principal_signature']);

        $setting->update([
            'meta' => [
                'principal_name' => $input['principalName'],
                'principal_signature' => $signature,
            ],
        ]);
    }
}
