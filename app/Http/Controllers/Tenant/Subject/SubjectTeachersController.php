<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\Subject\SubjectTeacher\CreateNewSubjectTeacherAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use Illuminate\Http\Request;

class SubjectTeachersController extends Controller
{

    public function store(Request $request)
    {
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        if( $request->input('classSectionCategory') ){
            $class = ClassSectionCategory::query()->where('uuid', '=', $request->input('classSectionCategory'))->first();
        }

        (new CreateNewSubjectTeacherAction())->execute($class, [
            'teacher_id' => $request->input('teacher'),
            'subject_id' => $request->input('subject'),
        ]);

        return redirect('/');
    }
}
