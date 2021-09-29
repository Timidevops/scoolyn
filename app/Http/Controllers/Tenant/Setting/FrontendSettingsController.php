<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\File\UploadFileAction;
use App\Actions\Tenant\Setting\FrontendSetting\UpdateFrontendSettingAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendSettingsController extends Controller
{
    public function edit()
    {
        return view('tenant.pages.setting.frontendSetting.edit', [
            'settings' => Setting::whereSettingName(Setting::FRONTEND_AUTH_IMAGE)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'frontImage' => ['required', 'file', 'image', 'max:10240'],
        ]);

        (new UpdateFrontendSettingAction)->execute([
            'file' =>  $request->file('frontImage'),
        ]);

        Session::flash('successFlash', 'Frontend setting updated successfully!!!');

        return back();
    }
}
