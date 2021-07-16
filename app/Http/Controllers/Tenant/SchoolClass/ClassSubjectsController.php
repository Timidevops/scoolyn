<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Illuminate\Http\Request;

class ClassSubjectsController extends Controller
{
    public function index(string $uuid)
    {
        $schoolClass   = SchoolClass::query()->where('slug', '=', $uuid)->first();

        //$classSubjects = ClassSubject::query()->whereIn('class_arm', collect($schoolClass->classArm)->pluck('uuid'))->get();

        $schoolClass->subject->load('subject');
        $classSubjects = collect($schoolClass->subject)->unique('subject_id')->values();
        //$classSubjects->load('subject');

        //dd($classSubjects);

        //$classSubjects = $schoolClass->subject->load(['subject', 'classSection', 'classSectionCategory']);

//        $classSectionCategory = $schoolClass->classSection->load('classSectionCategory');
//        $classSectionCategory->load('classSectionCategoryType');

        //dd($schoolClass->classArm);
        //dd( collect($schoolClass->subject)->unique() );
        return view('Tenant.pages.classes.subject', [
            'subjects'                 => Subject::query()->get(['uuid', 'subject_name']),
            'schoolClass'              => $schoolClass,
            'classSubjectsTotal'       => $classSubjects->count(),
            'classSubjects'            => $classSubjects,
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['uuid','category_name']),
            'classSectionType'         => ClassSectionType::query()->get(['uuid','section_name']),
        ]);
    }
}
