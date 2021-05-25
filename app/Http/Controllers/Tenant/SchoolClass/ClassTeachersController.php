<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use Illuminate\Http\Request;

class ClassTeachersController extends Controller
{
    public function store(Request $request)
    {
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        if( $request->input('classSectionCategory') ){
            $class = ClassSectionCategory::query()->where('uuid', '=', $request->input('classSectionCategory'))->first();
        }

        (new CreateNewClassTeacherAction())->execute($class, [
            'teacher_id' => $request->input('teacher')
        ]);

        return redirect('/');

    }
}
