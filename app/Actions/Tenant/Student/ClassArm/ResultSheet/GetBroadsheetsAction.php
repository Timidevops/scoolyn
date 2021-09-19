<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;


use App\Actions\Tenant\Result\Broadsheet\Helper\result\GetAllBroadsheetWithCaFormatAction;
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
        $totalMarkAttainable = 0;

        for ( $int = 0; $int < count($subjectId); $int++){

            $classSubjects = ClassSubject::query()->where('uuid', $subjectId[$int])->first();

            $this->studentId = $studentId;

            $academicBroadsheet = $classSubjects->academicBroadsheet()
                ->where('class_arm', $classArmId)
                ->get();

            $GetAllBroadsheetWithCaFormatAction = (new GetAllBroadsheetWithCaFormatAction($studentId))->execute($academicBroadsheet);

            $broadsheets ['subjects'][$subjectId[$int]] = collect($GetAllBroadsheetWithCaFormatAction['academicBroadsheets'])->get($studentId);

            $score += $this->getTotalMarkObtained( collect($GetAllBroadsheetWithCaFormatAction['academicBroadsheets'])->get($studentId) );

            $broadsheets['caFormat'] = $GetAllBroadsheetWithCaFormatAction['caFormats'];

            $totalMarkAttainable = collect($GetAllBroadsheetWithCaFormatAction['caFormats'])->sum('score');
        }

        $broadsheets['totalMarkAttainable'] = $totalMarkAttainable * count($subjectId);

        $broadsheets['totalMarkObtained'] = $score;

        return $broadsheets;
    }

    private function getTotalMarkObtained(array $broadsheets)
    {
       return collect($broadsheets)->sum();
    }

}
