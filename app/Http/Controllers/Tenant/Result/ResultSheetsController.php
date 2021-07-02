<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Http\Controllers\Controller;
use App\Jobs\Tenant\GenerateResultJob;
use Illuminate\Http\Request;

class ResultSheetsController extends Controller
{
    public function store()
    {
        //calls generate result job; job generate individual result sheet for each student
        GenerateResultJob::dispatch();
    }

}
