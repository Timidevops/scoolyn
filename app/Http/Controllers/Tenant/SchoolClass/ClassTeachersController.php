<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassTeachersController extends Controller
{
    public function single(string $uuid)
    {
        $schoolClass = SchoolClass::query()->where('slug', '=', $uuid)->first();

        $classArm    = $schoolClass->classArm->load(['teacher', 'classSection', 'classSectionCategory']);

        return view('tenant.pages.classes.teacher', [
            'schoolClass'          => $schoolClass,
            'teachers'             => $classArm,
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['uuid','category_name']),
            'classSectionType'         => ClassSectionType::query()->get(['uuid','section_name']),
        ]);
    }

}
