<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use function Spatie\Backup\BackupDestination\exists;

class AcademicSessionsController extends Controller
{
    public function index()
    {
        $academicSessions = AcademicSession::query()->get(['session_name','session_year','term','uuid']);

        $academicSessions->load('getTerm');

        return view('Tenant.pages.setting.academicCalendar.index', [
            'totalAcademicSessions' => AcademicSession::query()->count(),
            'academicSessions' => $academicSessions,
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.setting.academicCalendar.create',[
            'terms' => AcademicTerm::query()->get(['name', 'uuid']),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'term'    => ['required', 'exists:'.config('env.tenant.tenantConnection').'.academic_terms,uuid'],
            'sessionName' => ['required'],
            'sessionYear' => ['required'],
        ]);

        $sessionName = str_replace(' ', '/', $request->input('sessionName'));

        $request['sessionName'] = str_replace('-', '/', $sessionName);

        $academicSession = (new CreateNewAcademicSessionAction())->execute(camel_to_snake($request->only('sessionName','sessionYear', 'term')));

        if($request->has('currentSession')){

            (new SetCurrentAcademicCalendarAction())->execute([
                'setting_name'  => Setting::ACADEMIC_CALENDAR_SETTING,
                'setting_value' => (string) $academicSession->uuid,
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
