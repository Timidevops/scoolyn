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

        foreach ($classArm->classSubject as $classSubject){

            $classSubjectBroadsheet [$classSubject->uuid] = $this->getSubjectScores( collect($classSubject->academicBroadsheet->meta)->get('academicBroadsheet') );
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
        arsort($subjectScores);

        $position = 1;

        $studentPositions = [];

        foreach ($subjectScores as $key => $subjectScore){

            $searchKey = array_search($subjectScore, $subjectScores);

            //scenario; if same position retain position.
            if( $key != $searchKey){

                $studentPositions [$key] = [
                    'SubjectPosition' => (string) $position - 1,
                    'classAverage'    => (string) $this->getClassSubjectAverage($this->subjectScore)
                ];

                continue;
            }

            $studentPositions [$key] = [
                'SubjectPosition' => (string) $position,
                'classAverage'    => (string) $this->getClassSubjectAverage($this->subjectScore)
            ];

            $position ++;
        }

        return $studentPositions;
    }

    private function getClassSubjectAverage(array $subjectScores)
    {
        //@todo classAverage formula
       return round( array_sum($subjectScores) / count($subjectScores) );
    }
}
