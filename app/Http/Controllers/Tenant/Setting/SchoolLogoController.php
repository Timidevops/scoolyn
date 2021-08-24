<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Setting\SchoolLogo\UpdateSchoolLogoAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SchoolLogoController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'schoolLogo' => ['required', 'file', 'image', 'max:10240'],
        ]);

        (new UpdateSchoolLogoAction())->execute($request->except('_token'));

        Session::flash('successFlash', 'Principal details updated successfully!!!');

        return back();
    }
}
