<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Setting\PrincipalDetails\UpdatePrincipalDetailsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrincipalDetailsController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'principalName' => ['required'],
            'principalSignature' => ['required', 'file', 'image', 'max:10240'],
        ]);

        (new UpdatePrincipalDetailsAction())->execute($request->except('_token'));

        Session::flash('successFlash', 'Principal details updated successfully!!!');

        return back();
    }
}
