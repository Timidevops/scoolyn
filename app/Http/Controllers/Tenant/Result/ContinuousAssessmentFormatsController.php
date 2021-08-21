<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\ContinuousAssessment\CreateNewCAStructureAction;
use App\Actions\Tenant\Result\ContinuousAssessment\FilterFormInputAction;
use App\Actions\Tenant\Result\Helpers\GetNewStructureFormat;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ContinuousAssessmentFormatsController extends Controller
{
    public function index()
    {
        $caFormats = ContinuousAssessmentStructure::query()->get(['uuid','name','school_class','meta']);

        return view('Tenant.pages.result.caFormat.index', [
            'totalCaFormat' => ContinuousAssessmentStructure::query()->count(),
            'caFormats'     => collect( (new GetNewStructureFormat())->execute($caFormats) ),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.result.caFormat.create', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'numberOfCA' => ['required', 'gt:0'],
            'schoolClass' => ['required'],
            'schoolClass.*' => ['exists:school_classes,uuid'],
            'caName.*' => ['required'],
            'caScore.*' => ['required'],
            'totalCAScore' => [ Rule::in('100')]
        ]);

        $lastEntry   = ContinuousAssessmentStructure::all();
        $lastEntryId = $lastEntry->isEmpty() ? '' : "_{$lastEntry->last()->id}";

        $request['name'] = $request->input('name') ?? "continuous_assessment_format{$lastEntryId}";

        // get format :/ returns array
        $format = (new FilterFormInputAction())->execute([
            'numberOfCA' => $request->input('numberOfCA'),
            'caName'     => $request->input('caName'),
            'caScore'    => $request->input('caScore'),
        ]);

        $request['meta'] = $format;

        (new CreateNewCAStructureAction())->execute( camel_to_snake( $request->only(['name', 'meta', 'schoolClass']) ) );

        Session::flash('successFlash', 'Continuous assessment format added successfully!!!');

        return back();
    }
}
