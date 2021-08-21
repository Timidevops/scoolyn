<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\AcademicGrading\CreateNewGradingFormat;
use App\Actions\Tenant\Result\Helpers\GetNewStructureFormat;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AcademicGradingFormatsController extends Controller
{
    public function index()
    {
        $gradeFormats = AcademicGradingFormat::query()->get(['uuid','name','school_class','meta']);

        return view('Tenant.pages.result.academicGrading.index', [
            'totalGradeFormat' => AcademicGradingFormat::query()->count(),
            'gradeFormats'     => collect( (new GetNewStructureFormat())->execute($gradeFormats) ),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.result.academicGrading.create', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'schoolClass' => ['required'],
            'meta' => ['required']
        ], [
            'meta.required' => 'Academic grading is required'
        ]);

        $lastEntry   = AcademicGradingFormat::query()->latest();

        $lastEntryId = $lastEntry->exists() ? "_{$lastEntry->first()->id}" : '';

        $request['name'] = $request->input('name') ?? "academic_grading_format{$lastEntryId}";

        (new CreateNewGradingFormat())->execute(camel_to_snake($request->except('_token')));

        Session::flash('successFlash', 'Academic grading format added successfully!!!');

        return back();
    }
}
