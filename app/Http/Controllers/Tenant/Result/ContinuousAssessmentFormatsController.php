<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\ContinuousAssessment\CreateNewCAStructureAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ContinuousAssessmentStructure;
use Illuminate\Http\Request;

class ContinuousAssessmentFormatsController extends Controller
{

    public function store(Request $request)
    {
        $lastEntry   = ContinuousAssessmentStructure::all();
        $lastEntryId = $lastEntry->isEmpty() ? '' : $lastEntry->last()->id;

        $request['name'] = $request->input('name') ?? "default_$lastEntryId";

        //@todo --- form submission variables linkage ---
        $request['meta'] = $request->input('format');

        (new CreateNewCAStructureAction())->execute(camel_to_snake($request->only('name', 'meta')));

        return redirect('/');
    }
}
