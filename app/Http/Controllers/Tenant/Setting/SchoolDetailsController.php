<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Setting\SchoolDetails\UpdateSchoolDetailsAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SchoolDetailsController extends Controller
{
    public function edit()
    {
        return view('Tenant.pages.setting.SchoolDetails.edit', [
            'schoolDetails' => Setting::schoolDetails(),
            'principalDetails' => Setting::getSchoolPrincipal(),
            'schoolLogo' => Setting::getSchoolLogo(),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'schoolLocation' => ['required'],
            'contactNumber' => ['required'],
            'contactEmail' => ['required', 'email'],
        ]);

        (new UpdateSchoolDetailsAction())->execute($request->except('_token'));

        Session::flash('successFlash', 'School Details updated successfully!!!');

        return back();
    }
}
