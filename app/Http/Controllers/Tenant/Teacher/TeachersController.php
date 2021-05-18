<?php

namespace App\Http\Controllers\Tenant\Teacher;

use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeachersController extends Controller
{

    public function store(Request $request)
    {
        (new CreateNewTeacherAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
