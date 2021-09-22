<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;

use App\Actions\Tenant\Result\Broadsheet\Helper\result\GetAllBroadsheetWithCaFormatAction;
use App\Actions\Tenant\Result\Helpers\GetSubjectMetricAction;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;

class EvaluateSubjectMetricsAction
{
    public array $subjectScore;

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

            $academicBroadsheet =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->
                where('report_card', Setting::getCurrentCardBreakdownFormat())
                ->first();

            $academicBroadsheets =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)
                ->get();

            $getAllBroadsheetWithCaFormat = [];

            foreach ( collect(collect($academicBroadsheet->meta)->get('academicBroadsheet'))->keys() as $studentId){

                $getAllBroadsheetWithCaFormat = (new GetAllBroadsheetWithCaFormatAction($studentId))->execute($academicBroadsheets);
            }

            $classSubjectBroadsheet [$classSubject->uuid] = $this->getSubjectScores( ($getAllBroadsheetWithCaFormat['academicBroadsheets']) );
        }

        return $classSubjectBroadsheet;
    }

    private function getSubjectScores(array $broadsheets)
    {
        $subjectScores = [];

        foreach ($broadsheets as $key => $broadsheet){
            $subjectScores[$key] = collect($broadsheet)->sum();
        }

        $this->subjectScore = $subjectScores;

        return (new GetSubjectMetricAction)->execute($subjectScores);//$this->getSubjectMetric($subjectScores);
    }

    private function getSubjectMetric(array $subjectScores)
    {
        $studentPositions = getPosition($subjectScores, 'subjectPosition');

        $classAvg = $this->getClassSubjectAverage($subjectScores);

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
