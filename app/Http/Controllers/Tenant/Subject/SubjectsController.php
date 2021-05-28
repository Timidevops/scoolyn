<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\Subject\CreateNewSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{

    public function index()
    {
        return view('Tenant.pages.subject.subject', [
            'subjectTotal' => Subject::all()->count(),
            'subjects'     => Subject::query()->get(['uuid', 'subject_name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        (new CreateNewSubjectAction())->execute(camel_to_snake($request->except('_token')));

        return back();
    }
}
