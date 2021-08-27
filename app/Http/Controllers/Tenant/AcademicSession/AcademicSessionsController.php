<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AcademicSessionsController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.setting.academicCalendar.index', [
            'totalAcademicSessions' => AcademicSession::query()->count(),
            'academicSessions' => AcademicSession::all(),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.setting.academicCalendar.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'termName'    => ['required', Rule::in(['1','2','3'])],
            'sessionName' => ['required'],
            'sessionYear' => ['required'],
        ]);

        $sessionName = str_replace(' ', '/', $request->input('sessionName'));

        $request['sessionName'] = str_replace('-', '/', $sessionName);

        $academicSession =  (new CreateNewAcademicSessionAction())->execute(camel_to_snake($request->only('sessionName','sessionYear', 'termName')));

       // $academicTerm    =  (new CreateNewAcademicTermAction())->execute(camel_to_snake($request->only('termName')));

        if($request->has('currentSession')){

            (new SetCurrentAcademicCalendarAction())->execute([
                'setting_name'  => Setting::ACADEMIC_CALENDAR_SETTING,
                'setting_value' => (string) $academicSession->uuid,
                //                'meta' => [
//                    'session' => (string) $academicSession->uuid,
//                    'term'    => (string) $academicTerm->uuid,
//                ],
            ]);

            //set marker
            (new UpdateTodoItemAction())->execute([
                'name' => OnboardingTodoList::SET_ACADEMIC_CALENDAR
            ]);

        }

        Session::flash('successFlash', 'Current Academic Calendar set Successfully!!!');

        return back();
    }
}
