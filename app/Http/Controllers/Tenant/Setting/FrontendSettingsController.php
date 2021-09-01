<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;

class FrontendSettingsController extends Controller
{
    public function edit()
    {
        return view('Tenant.pages.setting.frontendSetting.edit', [
            'settings' => Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first(),
        ]);
    }
}
