<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolClassesController extends Controller
{

    public function store(Request $request)
    {
        $class = (new CreateNewSchoolClassAction())->execute(camel_to_snake($request->only('className')));

        $classSection = (new CreateNewClassSectionAction())->execute($class, [
            'section_name' => $request->input('sectionName') ?? 'default_class',
        ]);

        if( $request->input('categoryName') ){
            (new CreateNewClassSectionCategoryAction())->execute($classSection, camel_to_snake($request->only('categoryName')));
        }

        return redirect('/');
    }
}
