<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;


use App\Models\Tenant\ClassSubject;

class GetBroadsheetsAction
{
    public function execute(string $classArmId, string $studentId, array $subjectId)
    {
        /**
         * this action returns the subject broadsheet of each subject offered
         * by student with totalMarkObtained and totalMarkAttainable.
         */

        $broadsheets = [];

        $score = 0;

        for ( $int = 0; $int < count($subjectId); $int++){

            $classSubjects = ClassSubject::query()->where('uuid', $subjectId[$int])->first();

            $academicBroadsheet = $classSubjects->academicBroadsheet()->where('class_arm', $classArmId)->first();

            $broadsheets ['subjects'][$subjectId[$int]] = collect($academicBroadsheet->meta['academicBroadsheet'])->get($studentId);

            $score += $this->getTotalMarkObtained( collect($academicBroadsheet->meta['academicBroadsheet'])->get($studentId) );

            $broadsheets['caFormat'] = $academicBroadsheet->meta['caFormat'];
        }

        $broadsheets['totalMarkAttainable'] = 100 * count($subjectId);

        $broadsheets['totalMarkObtained'] = $score;

        return $broadsheets;
    }

    private function getTotalMarkObtained(array $broadsheets)
    {
       return $broadsheets['total'];
    }

}
