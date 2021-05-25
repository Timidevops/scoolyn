<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\Subject\CreateNewSubjectAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{

    public function store(Request $request)
    {
        (new CreateNewSubjectAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
