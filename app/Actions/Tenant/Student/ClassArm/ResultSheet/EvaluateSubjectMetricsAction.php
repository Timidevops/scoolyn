<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;

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

            $academicBroadsheet =  $classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->first();

            $classSubjectBroadsheet [$classSubject->uuid] = $this->getSubjectScores( collect($academicBroadsheet->meta)->get('academicBroadsheet') );
        }

        return $classSubjectBroadsheet;
    }

    private function getSubjectScores(array $broadsheets)
    {
        $subjectScores = [];

        foreach ($broadsheets as $key => $broadsheet){
            $subjectScores[$key] = $broadsheet['total'];
        }

        $this->subjectScore = $subjectScores;

        return $this->getSubjectMetric($subjectScores);
    }

    private function getSubjectMetric(array $subjectScores)
    {
        $studentPositions = getPosition($subjectScores, 'subjectPosition');

        $classAvg = $this->getClassSubjectAverage($subjectScores);

        return collect($studentPositions)->map(function ($item) use($classAvg){
            $item['classAverage'] = $classAvg;
            return $item;
        })->toArray();
    }

    private function getClassSubjectAverage(array $subjectScores)
    {
        //@todo classAverage formula
       return round( array_sum($subjectScores) / count($subjectScores) );
    }
}
