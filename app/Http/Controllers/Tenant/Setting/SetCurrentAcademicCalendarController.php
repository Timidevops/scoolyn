<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetCurrentAcademicCalendarController extends Controller
{
    public function store(Request $request)
    {
        $request['meta'] = [
            'term'     => $request->input('term'),
            'session'  => $request->input('session'),
        ];

        (new SetCurrentAcademicCalendarAction())->execute(camel_to_snake($request->only(['settingName', 'meta'])));

        return redirect('/');
    }
}
