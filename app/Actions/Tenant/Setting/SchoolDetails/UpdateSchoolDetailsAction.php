<?php


namespace App\Actions\Tenant\Setting\SchoolDetails;


use App\Models\Tenant\Setting;

class UpdateSchoolDetailsAction
{
    public function execute(array $input)
    {
        $this->updateSchoolLocation($input['schoolLocation']);

        $this->updateContactEmail($input['contactEmail']);

        $this->updateContactNumber($input['contactNumber']);
    }

    private function updateSchoolLocation(string $input)
    {
        $setting = Setting::whereSettingName(Setting::SCHOOL_LOCATION_SETTING)->first();

        $setting->update([
            'setting_value' => $input,
        ]);
    }

    private function updateContactNumber(string $input)
    {
        $setting = Setting::whereSettingName(Setting::CONTACT_NUMBER_SETTING)->first();

        $setting->update([
            'setting_value' => $input,
        ]);
    }

    private function updateContactEmail(string $input)
    {
        $setting = Setting::whereSettingName(Setting::CONTACT_EMAIL_SETTING)->first();

        $setting->update([
            'setting_value' => $input,
        ]);
    }
}
