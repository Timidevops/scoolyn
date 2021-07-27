<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.setting.index', [
            'currentAcademicSession' => Setting::getCurrentAcademicCalendarInWord(),
        ]);
    }

}
