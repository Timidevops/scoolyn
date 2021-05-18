<?php

namespace App\Http\Controllers\Tenant\SchoolClass;

use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassSubjectsController extends Controller
{

    public function store(Request $request)
    {
        (new CreateNewClassSubjectAction())->execute([
            'subject_id'       => $request->input('subject'),
            'school_class_id'  => $request->input('class'),
            'class_section_id' => $request->input('classSection') ?? null,
        ]);

        return redirect('/');
    }
}
