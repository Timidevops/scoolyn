<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;


use App\Models\Tenant\ClassSubject;

class GetBroadsheetsAction
{
    public function execute(string $studentId, array $subjectId)
    {
        /**
         * this action returns the subject broadsheet of each subject offered
         * by student with totalMarkObtained and totalMarkAttainable.
         */

        $broadsheets = [];

        $score = 0;

        for ( $int = 0; $int < count($subjectId); $int++){

            $classSubjects = ClassSubject::query()->where('uuid', $subjectId[$int])->first();

            $broadsheets ['subjects'][$subjectId[$int]] = collect($classSubjects->academicBroadsheet->meta['academicBroadsheet'])->get($studentId);

            $score += $this->getTotalMarkObtained( collect($classSubjects->academicBroadsheet->meta['academicBroadsheet'])->get($studentId) );
        }

        $broadsheets['totalMarkAttainable'] = 100 *count($subjectId);

        $broadsheets['totalMarkObtained'] = $score;

        return $broadsheets;
    }

    private function getTotalMarkObtained(array $broadsheets)
    {
       return $broadsheets['total'];
    }

}
