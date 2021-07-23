<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcademicSessionsController extends Controller
{

    public function create()
    {
        return view('Tenant.pages.setting.academicCalendar.create');
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            ''
//        ]);

        (new CreateNewAcademicSessionAction())->execute(camel_to_snake($request->except('_token', 'termName')));

        $request['currentTerm'] = $request->input('currentSession');

        (new CreateNewAcademicTermAction())->execute(camel_to_snake($request->only('termName', 'currentTerm')));

        return back();
    }
}
