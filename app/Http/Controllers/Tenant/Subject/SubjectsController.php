<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Subject\CreateNewSubjectAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\SchoolSubject;
use App\Models\Tenant\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubjectsController extends Controller
{
    public function index()
    {
        $schoolSubject = SchoolSubject::query()->pluck('subject_id');

        return view('Tenant.pages.subject.subject', [
            'subjectTotal'   => SchoolSubject::all()->count(),
            'schoolSubjects' => SchoolSubject::query()->get(['uuid', 'subject_name', 'slug']),
            'subjects'       => Subject::query()->get(['uuid', 'subject_name', 'slug'])->whereNotIn('uuid', $schoolSubject),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'subjects.*' => ['unique:school_subjects,subject_id'],
            'subjects'   => ['required', 'array','min:1']
        ]);

        foreach( $request->input('subjects') as $subjectId){

            $subject = Subject::query()->where('uuid', $subjectId)->first();

            (new CreateNewSubjectAction())->execute([
                'subject_name' => $subject->subject_name,
                'subject_id'   => (string) $subjectId,
            ]);
        }

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_SUBJECT
        ]);

        Session::flash('successFlash', 'Subject added successfully!!!');

        return back();
    }
}
