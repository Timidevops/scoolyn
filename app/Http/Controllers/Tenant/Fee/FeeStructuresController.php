<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewFeeStructureAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeeStructuresController extends Controller
{
    public function store(Request $request)
    {
        (new CreateNewFeeStructureAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
