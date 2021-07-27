<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\SchoolClass;

class SchoolClassesController extends Controller
{
    public function index()
    {
        $schoolClasses = (SchoolClass::all());

        $classArms = $schoolClasses->map(function ($schoolClass){
            $schoolClass['class_section'] = $schoolClass->classSectionType->unique();
            return $schoolClass;
        });

        return view('Tenant.classes', [
            'totalClass'               => SchoolClass::all()->count(),
            'schoolClasses'            => collect($classArms),
            'classSectionType'         => ClassSectionType::query()->get(['section_name', 'uuid']),
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['category_name', 'uuid']),
        ]);
    }
}
