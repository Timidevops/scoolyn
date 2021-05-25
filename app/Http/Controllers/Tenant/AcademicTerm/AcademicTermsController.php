<?php

namespace App\Http\Controllers\Tenant\AcademicTerm;

use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcademicTermsController extends Controller
{
    public function store(Request $request)
    {
        (new CreateNewAcademicTermAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
