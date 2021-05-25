<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\Subject\CreateNewSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{

    public function index()
    {
        return view('Tenant.subject', [
            'subjectTotal' => Subject::all()->count(),
        ]);
    }

    public function store(Request $request)
    {
        (new CreateNewSubjectAction())->execute(camel_to_snake($request->except('_token')));

        return redirect('/');
    }
}
