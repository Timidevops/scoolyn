<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Actions\Tenant\Setting\ReportCardBreakdownFormat\CreateReportCardBreakdownFormatAction;
use App\Actions\Tenant\Setting\ReportCardBreakdownFormat\UpdateReportCardBreakdownFormatSettingAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportCardBreakdownFormatsController extends Controller
{
    public function edit()
    {
        return view('Tenant.pages.setting.reportCardBreakdownFormat.index', [
            'isReportCardAssessmentFormatSet' => Setting::isReportCardBreakdownFormatCreated(),
            'currentReportFormat' => Setting::getCurrentCardBreakdownFormat(),
            'reportCardBreakdownFormats' => Setting::whereSettingName(Setting::REPORT_CARD_BREAKDOWN_FORMAT)->first()->meta,
        ]);
    }

    public function update(Request $request)
    {
        if ( ! Setting::isReportCardBreakdownFormatCreated() ){

            $this->create($request);
        }

        $this->validate($request, [
            'currentReportFormat' => ['required'],
        ]);

        $setting = Setting::whereSettingName(Setting::REPORT_CARD_BREAKDOWN_FORMAT)->first()->meta;

        if ( ! collect($setting)->contains($request->input('currentReportFormat')) ){
            Session::flash('errorFlash', 'Error processing request, try again.');

            return back();
        }

        (new UpdateReportCardBreakdownFormatSettingAction)->execute([
            'setting_value' => $request->input('currentReportFormat'),
        ]);

        Session::flash('successFlash', 'Current report card updated changed successfully!!!');

        return back();
    }

    private function create(Request $request)
    {
        $this->validate($request, [
            'nameOfReport' => ['required', 'array', 'min:1'],
        ]);

        (new CreateReportCardBreakdownFormatAction)->execute([
            'setting_name' => Setting::REPORT_CARD_BREAKDOWN_FORMAT,
            'meta' => $request->input('nameOfReport'),
        ]);

        (new UpdateReportCardBreakdownFormatSettingAction)->execute([
            'setting_name' => Setting::REPORT_CARD_BREAKDOWN_FORMAT_SETTING,
            'setting_value' => $request->input('nameOfReport')[0],
        ]);

        Session::flash('successFlash','Report card format set successfully!!!');

        return back();
    }
}
