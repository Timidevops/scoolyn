<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    public function index(Request $request)
    {
        //@todo change to auth parent...
        $parent = Parents::find(1);

        //@todo adjust to live-wire
        dd($request->has('ward'));
    }
}
