<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentsController extends Controller
{

    public function store(Request $request)
    {
        (new CreateNewParentAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
