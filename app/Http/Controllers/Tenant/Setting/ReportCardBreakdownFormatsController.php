<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Setting\ReportCardBreakdownFormat\CreateReportCardBreakdownFormatAction;
use App\Actions\Tenant\Setting\ReportCardBreakdownFormat\UpdateReportCardBreakdownFormatSettingAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportCardBreakdownFormatsController extends Controller
{
    private array $checker = [];

    public function edit()
    {
        return view('Tenant.pages.setting.reportCardBreakdownFormat.index', [
            'isReportCardAssessmentFormatSet' => Setting::isReportCardBreakdownFormatCreated(),
            'currentReportFormat' => Setting::getCurrentCardBreakdownFormat(),
            'reportCardBreakdownFormats' => ReportCardBreakdownFormat::query()->get(['name','uuid']),
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nameOfReport' => ['required', 'array', 'min:1'],
        ]);

        foreach($request->input('nameOfReport') as $format){
            (new CreateReportCardBreakdownFormatAction)->execute([
                'name' => $format,
            ]);
        }

        (new UpdateReportCardBreakdownFormatSettingAction)->execute([
            'setting_name'  => Setting::REPORT_CARD_BREAKDOWN_FORMAT_SETTING,
            'setting_value' => (string) ReportCardBreakdownFormat::query()->first()->uuid,
        ]);

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::SET_REPORT_CARD_BREAKDOWN_FORMAT
        ]);

        Session::flash('successFlash','Report card format set successfully!!!');

        return back();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'currentReportFormat' => ['required', 'exists:'.config('env.tenant.tenantConnection').'.report_card_breakdown_formats,uuid'],
        ]);

        ClassArm::all()->map(function ($classArm){
            $classArm->academicResult()->where('report_card', Setting::getCurrentCardBreakdownFormat())->exists() == false
                ? $this->checker [] = $classArm
                : null;
        });

        AcademicResult::query()->where('report_card', Setting::getCurrentCardBreakdownFormat())->get()->map(function ($result){
            $result->status != AcademicResult::APPROVED_RESULT_STATUS ? $this->checker [] = $result : null;
        });

        if ( count($this->checker) > 0 ){

            Session::flash('warningFlash', 'Cannot change report card, pending result sheet for some classes.');

            return back();
        }

        if ( $request->input('currentReportFormat') == Setting::getCurrentCardBreakdownFormat() ){

            Session::flash('errorFlash', 'Cannot change report to the same report');

            return back();
        }

        (new UpdateReportCardBreakdownFormatSettingAction)->execute([
            'setting_value' => $request->input('currentReportFormat'),
        ]);

        $requestCurrentReportFormat = $request->input('currentReportFormat');

        ClassArm::all()->map(function ($classArm) use ($requestCurrentReportFormat){
            if ( collect($classArm->students)->count() != $classArm->academicResult()->where('report_card', $requestCurrentReportFormat)->get()->count() ){
                $classArm->setStatus(ClassArm::NEW_REPORT_STATUS, Setting::getCurrentCardBreakdownFormat(true));
            }
        });

        Session::flash('successFlash', 'Current report card updated changed successfully!!!');

        return back();
    }

}
