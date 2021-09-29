<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Result\AcademicGrading\CreateNewGradingFormat;
use App\Actions\Tenant\Result\Helpers\GetNewStructureFormat;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AcademicGradingFormatsController extends Controller
{
    public function index()
    {
        $gradeFormats = AcademicGradingFormat::query()->get(['uuid','name','school_class','meta']);

        return view('tenant.pages.result.academicGrading.index', [
            'totalGradeFormat' => AcademicGradingFormat::query()->count(),
            'gradeFormats'     => collect( (new GetNewStructureFormat())->execute($gradeFormats) ),
            'reportBreakdown'  => ReportCardBreakdownFormat::query()->get(['uuid', 'name']),
        ]);
    }

    public function create()
    {
        $schoolClasses = AcademicGradingFormat::all()->map(function ($item){
            return $item->school_class;
        });

        $schoolClasses = collect( collect($schoolClasses)->flatten() )->unique();

        return view('tenant.pages.result.academicGrading.create', [
            'schoolClasses' => SchoolClass::query()->whereNotIn('uuid', $schoolClasses)->get(['uuid', 'class_name']),
            'reportCardFormats' => (ReportCardBreakdownFormat::query()->get(['uuid', 'name'])),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'schoolClass' => ['required'],
            'meta' => ['required', 'array'],
            'meta.*.nameOfReport' => ['required'],
            'meta.*.gradingFormat' => ['required', 'array'],
            'meta.*.gradingFormat.*.from' => ['required'],
            'meta.*.gradingFormat.*.to' => ['required'],
            'meta.*.gradingFormat.*.grade' => ['required'],
            'meta.*.gradingFormat.*.comment' => ['required'],
            'meta.*.gradingFormat.*.color' => ['required'],
        ], [
            'meta.required' => 'Academic grading is required',
            'meta.*.nameOfReport.required' => 'Invalid, try again.',
            'meta.*.gradingFormat.required' => 'Kindly fill all fields.',
            'meta.*.gradingFormat.*.from.required' => 'Kindly fill all fields.',
            'meta.*.gradingFormat.*.to.required' => 'Kindly fill all fields.',
            'meta.*.gradingFormat.*.grade.required' => 'Kindly fill all fields.',
            'meta.*.gradingFormat.*.comment.required' => 'Kindly fill all fields.',
            'meta.*.gradingFormat.*.color.required' => 'Kindly fill all fields.',
        ]);

        $lastEntry   = AcademicGradingFormat::query()->latest();

        $lastEntryId = $lastEntry->exists() ? "_{$lastEntry->first()->id}" : '';

        $request['name'] = $request->input('name') ?? "academic_grading_format{$lastEntryId}";

        (new CreateNewGradingFormat())->execute(camel_to_snake($request->except('_token')));

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_GRADING_FORMAT
        ]);

        Session::flash('successFlash', 'Academic grading format added successfully!!!');

        return back();
    }
}
