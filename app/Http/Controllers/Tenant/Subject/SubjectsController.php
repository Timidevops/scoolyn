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
use Ramsey\Uuid\Uuid;

class SubjectsController extends Controller
{
    public function index()
    {
        $schoolSubject = SchoolSubject::query()->pluck('subject_id');

        return view('tenant.pages.subject.subject', [
            'subjectTotal'   => SchoolSubject::all()->count(),
            'schoolSubjects' => SchoolSubject::query()->get(['uuid', 'subject_name', 'slug']),
            'subjects'       => Subject::query()->whereNotIn('uuid', $schoolSubject)->get(['uuid', 'subject_name', 'slug']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'subjects.*' => ['unique:'.config('env.tenant.tenantConnection').'.school_subjects,subject_id'],
            'subjects'   => ['nullable', 'array','min:1'],
            'newSubject' => ['nullable','unique:'.config('env.tenant.tenantConnection').'.school_subjects,subject_name'],
        ]);

        if( $request->input('subjects') ){
            foreach( $request->input('subjects') as $subjectId){

            $subject = Subject::query()->where('uuid', $subjectId)->first();

            (new CreateNewSubjectAction())->execute([
                'subject_name' => $subject->subject_name,
                'subject_id'   => (string) $subjectId,
                ]);
            }
        }

        if( $request->input('newSubject') ){
            $subject = Subject::query()->create([
                'uuid' => Uuid::uuid4(),
                'subject_name' => $request->input('newSubject'),
            ]);

            (new CreateNewSubjectAction())->execute([
                'subject_name' => $subject->subject_name,
                'subject_id'   => (string) $subject->uuid,
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
