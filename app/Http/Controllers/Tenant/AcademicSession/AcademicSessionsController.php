<?php

namespace App\Http\Controllers\Tenant\AcademicSession;

use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Actions\Tenant\AcademicSession\ProcessNewSessionAction;
use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\IsSessionCompletedAction;
use App\Actions\Tenant\Setting\ReportCardBreakdownFormat\UpdateReportCardBreakdownFormatSettingAction;
use App\Actions\Tenant\Setting\SetCurrentAcademicCalendarAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use function Spatie\Backup\BackupDestination\exists;

class AcademicSessionsController extends Controller
{
    private array $checker = [];

    public function index()
    {
        $academicSessions = AcademicSession::query()->get(['session_name','session_year','term','uuid']);

        $academicSessions->load('getTerm');

        return view('tenant.pages.setting.academicCalendar.index', [
            'totalAcademicSessions' => AcademicSession::query()->count(),
            'academicSessions' => $academicSessions,
        ]);
    }

    public function create()
    {
        if ( ! Setting::isAcademicCalendarSet() ){
            return view('tenant.pages.setting.academicCalendar.create',[
                'terms' => AcademicTerm::query()->get(['name', 'uuid']),
                'currentSession' => '',
            ]);
        }

        $currentSession = AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId());

        $possibleNexSession = $currentSession->session_year + 1 ."/". (($currentSession->session_year + 1) + 1 );

        return  view('tenant.pages.setting.academicCalendar.edit', [
            'terms' => AcademicTerm::query()->get(['name', 'uuid']),
            'currentSession' => $currentSession,
            'possibleNexSession' => $possibleNexSession,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->has('update')){
            return $this->update($request);
        }

        $this->validate($request, [
            'term'    => ['required', 'exists:'.config('env.tenant.tenantConnection').'.academic_terms,uuid'],
            'sessionName' => ['required', 'unique:'.config('env.tenant.tenantConnection').'.academic_sessions,session_name'],
            'sessionYear' => ['required', 'unique:'.config('env.tenant.tenantConnection').'.academic_sessions,session_year'],
        ]);

        $sessionChecker = (bool) AcademicSession::all()->last() ? (new IsSessionCompletedAction)->execute() : true;

        if ( ! $sessionChecker ){

            Session::flash('warningFlash', 'Cannot change session, pending report and term sheet.');

            return back();
        }

        $sessionName = str_replace(' ', '/', $request->input('sessionName'));

        $request['sessionName'] = str_replace('-', '/', $sessionName);

        try {
            DB::beginTransaction();

            $academicSession = (new CreateNewAcademicSessionAction())->execute(camel_to_snake($request->only('sessionName','sessionYear', 'term')));

            if ( Setting::isAcademicCalendarSet() ){
                //retain previous session data
                (new ProcessNewSessionAction($academicSession))->execute();

                (new UpdateReportCardBreakdownFormatSettingAction)->execute([
                    'setting_name'  => Setting::REPORT_CARD_BREAKDOWN_FORMAT_SETTING,
                    'setting_value' => (string) ReportCardBreakdownFormat::query()->first()->uuid,
                ]);
            }
            else{
                // create dummy class arm
                ClassArm::query()->create([
                    'uuid' => Uuid::uuid4(),
                    'school_class_id' => SchoolClass::query()->where('level', '4')->first()->uuid,
                    'academic_session_id' => (string) $academicSession->uuid,
                ]);
            }

            (new SetCurrentAcademicCalendarAction())->execute([
                'setting_name'  => Setting::ACADEMIC_CALENDAR_SETTING,
                'setting_value' => (string) $academicSession->uuid,
            ]);

            //set marker
            (new UpdateTodoItemAction())->execute([
                'name' => OnboardingTodoList::SET_ACADEMIC_CALENDAR
            ]);

            DB::commit();
        }
        catch (\Exception $exception){
            //@todo log
            DB::rollBack();

            Session::flash('errorFlash', 'Error creating academic session, try again.');
            return back();
        }

        Session::flash('successFlash', 'Current Academic Calendar set Successfully!!!');

        return back();
    }

    private function update(Request $request)
    {
        $this->validate($request, [
            'term' => ['required', 'exists:'.config('env.tenant.tenantConnection').'.academic_terms,uuid'],
        ]);

        $lastReport = ReportCardBreakdownFormat::all()->last();

        ClassArm::all()->map(function ($classArm) use($lastReport){
            $classArm->academicResult()->where('report_card', $lastReport->uuid)->exists() == false
                ? $this->checker [] = $classArm
                : null;
        });

        AcademicResult::query()->where('report_card', $lastReport->uuid)->get()->map(function ($result){
            $result->status != AcademicResult::APPROVED_RESULT_STATUS ? $this->checker [] = $result : null;
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

        $reportCard = ReportCardBreakdownFormat::all()->first();

        (new UpdateReportCardBreakdownFormatSettingAction)->execute([
            'setting_value' => $reportCard->uuid,
        ]);

        ClassArm::all()->map(function ($classArm) use ($reportCard){
            if ( collect($classArm->students)->count() != $classArm->academicResult()->where('report_card', $reportCard->uuid)->get()->count() ){
                $classArm->setStatus(ClassArm::NEW_REPORT_STATUS, Setting::getCurrentCardBreakdownFormat(true));
            }
        });

        Session::flash('successFlash', 'Academic session set successfully!!!');

        return back();
    }

    private function getNewTerm(int $currentSessionId)
    {
        $nextId = $currentSessionId + 1;
        return AcademicTerm::find($nextId) ? AcademicTerm::find($nextId)->uuid : 'nil';
    }
}
