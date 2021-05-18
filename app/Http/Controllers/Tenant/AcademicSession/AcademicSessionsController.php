<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcademicSessionsController
{

    public function store(Request $request)
    {
        (new CreateNewAcademicSessionAction)->execute($request->except('_token'));

        return redirect('/');
    }
}
