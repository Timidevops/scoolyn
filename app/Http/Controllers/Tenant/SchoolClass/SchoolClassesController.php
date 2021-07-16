<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassSectionCategoryTypeAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionTypeAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SchoolClassesController extends Controller
{
    public function index()
    {
        $schoolClasses = (SchoolClass::all());
        $schoolClasses->load(['classSectionType']);

        return view('Tenant.classes', [
            'totalClass'               => SchoolClass::all()->count(),
            'schoolClasses'            => collect($schoolClasses),
            'classSectionType'         => ClassSectionType::query()->get(['section_name', 'uuid']),
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['category_name', 'uuid']),
        ]);
    }
}
