<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassSubjectsController extends Controller
{

    public function index(string $uuid)
    {
        $schoolClass = SchoolClass::query()->where('slug', '=', $uuid)->first();

        $schoolClass->load('classSectionType');
        $schoolClass->classSection->load('classSectionCategoryType');

        //$classSectionCategoryType = ClassSectionCategoryType::query()->get(['uuid','category_name']);//$schoolClass->classSection->load('classSectionCategoryType');
        $classSubjects = $schoolClass->subject->load('subject');

        return view('Tenant.pages.classes.subject', [
            'subjects'                 => Subject::query()->get(['uuid', 'subject_name']),
            'classSections'            => $schoolClass,//$schoolClass->classSectionType()->get(),
            'classSubjectsTotal'       => $schoolClass->subject->count(),
            'classSubjects'            => $classSubjects,//$schoolClass->subject,
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['uuid','category_name']),
            'classSectionType'         => ClassSectionType::query()->get(['uuid','section_name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        (new CreateNewClassSubjectAction())->execute([
            'subject_id'                => $request->input('subject'),
            'school_class_id'           => $request->input('class'),
            'class_section_id'          => $request->input('classSection') === 'all' ? null : $request->input('classSection') ?? null,
            'class_section_category_id' => $request->input('classSection') === 'all' ? null : $request->input('classSectionCategory') ?? null,
        ]);

        return back();
    }
}
