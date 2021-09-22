<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use function Spatie\Backup\BackupDestination\exists;

class AcademicSessionsController extends Controller
{
    private array $checker = [];

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
        if ( ! Setting::isAcademicCalendarSet() ){
            return view('Tenant.pages.setting.academicCalendar.create',[
                'terms' => AcademicTerm::query()->get(['name', 'uuid']),
            ]);
        }

        return  view('Tenant.pages.setting.academicCalendar.edit', [
            'terms' => AcademicTerm::query()->get(['name', 'uuid']),
            'currentSession' => AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId()),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->has('update')){
            return $this->update($request);
        }

        $this->validate($request, [
            'term'    => ['required', 'exists:'.config('env.tenant.tenantConnection').'.academic_terms,uuid'],
            'sessionName' => ['required'],
            'sessionYear' => ['required'],
        ]);

        $sessionName = str_replace(' ', '/', $request->input('sessionName'));

        $request['sessionName'] = str_replace('-', '/', $sessionName);

        $academicSession = (new CreateNewAcademicSessionAction())->execute(camel_to_snake($request->only('sessionName','sessionYear', 'term')));

        (new SetCurrentAcademicCalendarAction())->execute([
            'setting_name'  => Setting::ACADEMIC_CALENDAR_SETTING,
            'setting_value' => (string) $academicSession->uuid,
        ]);

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::SET_ACADEMIC_CALENDAR
        ]);

        Session::flash('successFlash', 'Current Academic Calendar set Successfully!!!');

        return back();
    }

    private function update(Request $request)
    {
        $this->validate($request, [
            'term' => ['required', 'exists:'.config('env.tenant.tenantConnection').'.academic_terms,uuid'],
        ]);

        $lastReport = ReportCardBreakdownFormat::all()->last();

        //@todo check if result sheet is approved...
        ClassArm::all()->map(function ($classArm) use($lastReport){
            $classArm->academicResult()->where('report_card', $lastReport->uuid)->exists() == false ? $this->checker [] = $classArm : null;
        });

        if ( count($this->checker) > 0 ){
            Session::flash('warningFlash', 'Cannot change term, pending term result sheets.');

            return back();
        }

        $currentAcademicSession = AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId());

        if ( $request->input('term') != $this->getNewTerm($currentAcademicSession->getTerm->id) ){
            Session::flash('errorFlash', "Term selected is not the next.");

            return back();
        }

        $currentAcademicSession->update([
            'term' => $request->input('term'),
        ]);

        Session::flash('successFlash', 'Academic session set successfully!!!');

        return back();
    }

    private function getNewTerm(int $currentSessionId)
    {
        $nextId = $currentSessionId + 1;
        return AcademicTerm::find($nextId) ? AcademicTerm::find($nextId)->uuid : 'nil';
    }
}
