<?php


namespace App\Actions\Tenant\Result\Broadsheet\Helper;


use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\Setting;

class SumCAScorePerStudentAction
{
    /**
     * @param array $broadsheets
     * @param array $caFormat
     * @return array|bool
     */
    public function execute(array $broadsheets, array $caFormat)
    {
        $totalReportCardScore = collect($caFormat)->sum('score');


        foreach ($broadsheets as $key => $broadsheet){
            if( array_sum($broadsheet) > $totalReportCardScore ){
                return false;
            }
            $broadsheets[$key]['total'] = (string) array_sum($broadsheet);
        }

        return $broadsheets;
    }
}
