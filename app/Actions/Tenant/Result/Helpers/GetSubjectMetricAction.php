<?php


namespace App\Actions\Tenant\Result\Helpers;


class GetSubjectMetricAction
{
    public function execute(array $data)
    {
        $studentPositions = getPosition($data, 'subjectPosition');

        $classAvg = $this->getClassSubjectAverage($data);

        return collect($studentPositions)->map(function ($item, $index) use($classAvg, $data){
            $item['classAverage'] = $classAvg;
            //$item['total'] = collect($data)->get($index);
            return $item;
        })->toArray();
    }

    private function getClassSubjectAverage(array $subjectScores)
    {
        //@todo classAverage formula
        return round( array_sum($subjectScores) / count($subjectScores) );
    }
}
