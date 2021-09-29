<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AdmissionSettingsController extends Controller
{
    public function edit()
    {
        return view('tenant.pages.setting.admissionSetting.edit', [
            'settingValue' => (bool) Setting::isAdmissionOn(),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'isAdmissionOn' => ['required', Rule::in(['1','0'])],
        ]);

        $setting = Setting::whereSettingName(Setting::ADMISSION_STATUS);

        $setting->update([
            'setting_value' => $request->input('isAdmissionOn'),
        ]);

        Session::flash('successFlash', 'Admission setting updated successfully!!!');

        return back();
    }
}
