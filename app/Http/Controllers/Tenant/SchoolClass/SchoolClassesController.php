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
        $schoolClasses->load('classSectionType');

        return view('Tenant.classes', [
            'totalClass'               => SchoolClass::all()->count(),
            'schoolClasses'            => collect($schoolClasses),
            'classSectionType'         => ClassSectionType::query()->get(['section_name', 'uuid']),
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['category_name', 'uuid']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $class = SchoolClass::query()->where('uuid', '=', $request->only('className'))->first();

        //dd($class);
        if( ! $class ){
            $class = (new CreateNewSchoolClassAction())->execute(camel_to_snake($request->only('className')));
        }

        $classSectionType = $request->input('classSectionType');
        if( $request->input('newSectionName') ){
            // create new class section type
            $classSectionType = (new CreateNewClassSectionTypeAction())->execute([
                'section_name' => $request->input('newSectionName') ?? 'default_class',
            ]);
            $classSectionType = $classSectionType->uuid;
        }

        $classSection = (new CreateNewClassSectionAction())->execute([
            'class_section_types_id' => $classSectionType,
            'school_class_id'        => $class->uuid,
        ]);

        if( $request->input('categoryName') || $request->input('newClassSectionCategoryType') ){

            $classSectionCategoryType = $request->input('classSectionCategoryType');

            if( $request->input('newClassSectionCategoryType') ){
                // create new class section category type
                $classSectionCategoryType = (new CreateNewClassSectionCategoryTypeAction())->execute([
                    'category_name' => $request->input('newClassSectionCategoryType'),
                ]);
                $classSectionCategoryType = $classSectionCategoryType->uuid;
            }

            (new CreateNewClassSectionCategoryAction())->execute([
                'class_section_category_types_id' => $classSectionCategoryType,
                'class_section_id'                => $classSection->uuid,
            ]);
        }

        return back();
    }
}
