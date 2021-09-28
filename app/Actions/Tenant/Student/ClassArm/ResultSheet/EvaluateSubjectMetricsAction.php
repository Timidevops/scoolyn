<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;

use App\Actions\Tenant\Result\Broadsheet\Helper\result\GetAllBroadsheetWithCaFormatAction;
use App\Actions\Tenant\Result\Helpers\GetSubjectMetricAction;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;

class EvaluateSubjectMetricsAction
{
    public array $subjectScore;
    public array $academicBroadsheetScore;

    public function execute(Model $classArm)
    {
        /**
         * this action calculates the subject position, class average
         */

        $classSubjectBroadsheet = [];

        $classSubjects = $classArm->classSubject->filter(function ($classSubject) use($classArm){

            if($classSubject->class_arm){
                return $classSubject->whereJsonContains('class_arm', $classArm->uuid);
            }
            elseif ($classSubject->class_section_id && ! $classSubject->class_section_category_id){
                return $classSubject->class_section_id == $classArm->class_section_id;
            }

            return $classSubject->class_section_id == $classArm->class_section_id && $classSubject->class_section_category_id == $classArm->class_section_category_id;
        });

        foreach ($classSubjects as $classSubject){

            $academicBroadsheets =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)
                ->get();

//            if ( $academicBroadsheets->count() <= 1 ){
//
//                $academicBroadsheets =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->
//                where('report_card', Setting::getCurrentCardBreakdownFormat())
//                    ->first();
//
//                $classSubjectBroadsheet [$classSubject->uuid] = $this->getSubjectScores( collect($academicBroadsheets->meta)->get('academicBroadsheet') );
//
//                return $classSubjectBroadsheet;
//            }

            $academicBroadsheet =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->
            where('report_card', Setting::getCurrentCardBreakdownFormat())
                ->first();

            $getAllBroadsheetWithCaFormats = [];

            foreach ( collect(collect($academicBroadsheet->meta)->get('academicBroadsheet'))->keys() as $studentId){
                $getAllBroadsheetWithCaFormats []  = (new GetAllBroadsheetWithCaFormatAction($studentId))->execute($academicBroadsheets);
            }

            collect($getAllBroadsheetWithCaFormats)->map(function ($broadsheet){
                collect($broadsheet['academicBroadsheets'])->map(function ($item, $index){
                    $this->academicBroadsheetScore [$index] = $item;
                })->toArray();
            })->toArray();

            $classSubjectBroadsheet [$classSubject->uuid] = $this->getSubjectScores( $this->academicBroadsheetScore );

        }

        return $classSubjectBroadsheet;
    }

    private function getSubjectScores(array $broadsheets)
    {
        $subjectScores = [];

        $subjectMetrics = [];

        foreach ( $broadsheets as $key => $broadsheet){
            //@todo if not 3rd term
//            $subjectScores[$key] = collect($broadsheet['total'])->sum();
//
//            $subjectMetrics [$key]['total'] = $broadsheet['total'];


            $subjectScores[$key] = collect($broadsheet)->sum();

            $subjectMetrics [$key]['total'] = collect($broadsheet)->sum();
        }

        $getSubjectMetrics = (new GetSubjectMetricAction)->execute($subjectScores);

        return collect($subjectMetrics)->map(function ($subjectMetric, $key) use ($getSubjectMetrics){
            $subjectMetrics ['subjectPosition'] = $getSubjectMetrics[$key]['subjectPosition'];

            $subjectMetrics ['classAverage']    = $getSubjectMetrics[$key]['classAverage'];

            $subjectMetrics ['total']    = $subjectMetric['total'];

            return $subjectMetrics;
        });
    }

    private function getSubjectMetric(array $subjectScores)
    {
        $studentPositions = getPosition($subjectScores, 'subjectPosition');

        $classAvg = 0;//$this->getClassSubjectAverage($subjectScores);

        return collect($studentPositions)->map(function ($item, $index) use($classAvg, $subjectScores){
            $item['classAverage'] = $classAvg;
            $item['total'] = collect($subjectScores)->get($index);
            return $item;
        })->toArray();
    }

    private function getClassSubjectAverage(array $subjectScores)
    {
        //@todo classAverage formula
       return round( array_sum($subjectScores) / count($subjectScores) );
    }
}
