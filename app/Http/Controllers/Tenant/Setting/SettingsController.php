<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\AuthController;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;

class SettingsController extends AuthController
{
    public function index()
    {
        return view('Tenant.pages.setting.index', [
            'currentAcademicSession' => $this->currentAcademicSession,
        ]);
    }

}
