<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        dd($request->has('ward'));
    }
}
