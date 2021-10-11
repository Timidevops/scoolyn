<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Result\ContinuousAssessment\CreateNewCAStructureAction;
use App\Actions\Tenant\Result\Helpers\GetNewStructureFormat;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\ReportCardBreakdownFormat;
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

        return view('tenant.pages.result.caFormat.index', [
            'totalCaFormat'   => ContinuousAssessmentStructure::query()->count(),
            'caFormats'       => collect( (new GetNewStructureFormat())->execute($caFormats) ),
            'reportBreakdown' => ReportCardBreakdownFormat::query()->get(['uuid', 'name']),
        ]);
    }

    public function create()
    {
        $schoolClasses = ContinuousAssessmentStructure::all()->map(function ($item){
            return $item->school_class;
        });

        $schoolClasses = collect( collect($schoolClasses)->flatten() )->unique();

        return view('tenant.pages.result.caFormat.create', [
            'schoolClasses' => SchoolClass::query()->whereNotIn('uuid', $schoolClasses)->get(['uuid', 'class_name']),
            'reportCardFormats' => (ReportCardBreakdownFormat::query()->get(['uuid', 'name'])),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'schoolClass' => ['required'],
            'schoolClass.*' => ['exists:'.config('env.tenant.tenantConnection').'.school_classes,uuid'],
            'reportFormat' => ['required', 'array'],
            'reportFormat.*.nameOfReport' => ['required'],
            'reportFormat.*.caFormat' => ['required', 'array'],
            'reportFormat.*.caFormat.*.name' => ['required'],
            'reportFormat.*.caFormat.*.score' => ['required'],
            'totalCAScore' => [ Rule::in('100')]
        ], [
            'reportFormat.*.nameOfReport.required' => 'The report name is required',
            'reportFormat.*.caFormat.required' => 'kindly add continuous assessments for report card',
            'reportFormat.*.caFormat.*.name.required' => 'Name of continuous assessment is required',
            'reportFormat.*.caFormat.*.score.required'=> 'Total mark attainable is required',
        ]);

        $lastEntry   = ContinuousAssessmentStructure::all();
        $idNum = ! $lastEntry->isEmpty() ? $lastEntry->last()->id + 1 : '';
        $lastEntryId = $lastEntry->isEmpty() ? '' : "_$idNum";

        $request['name'] = $request->input('name') ?? "continuous_assessment_format{$lastEntryId}";

        $request['meta'] = $request->input('reportFormat');

        (new CreateNewCAStructureAction())->execute( camel_to_snake( $request->only(['name', 'meta', 'schoolClass']) ) );

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_CA_FORMAT
        ]);

        Session::flash('successFlash', 'Continuous assessment format added successfully!!!');

        return back();
    }
}
