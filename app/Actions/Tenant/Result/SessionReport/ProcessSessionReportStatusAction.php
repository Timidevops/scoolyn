<?php


namespace App\Actions\Tenant\Result\SessionReport;


use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\AcademicSessionResult;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Model;

class ProcessSessionReportStatusAction
{
    private array $checker = [];

    public function execute(Model $classArm)
    {
        collect($classArm->academicResultWithCurrentReport)->map(function ($academicResult){
            if( $academicResult->status != AcademicResult::APPROVED_RESULT_STATUS ){
                $this->checker [] = $academicResult;
            }
        });

        if ( count($this->checker) == 0 ){
            //update all session result to active result status
            collect($classArm->students)->map(function ($studentId){

                $sessionResult = Student::whereUuid($studentId)->academicSessionResult()->first();

                $sessionResult->setStatus(AcademicSessionResult::ACTIVE_STATUS);
            });

            $classArm->setStatus(ClassArm::SESSION_COMPLETED_STATUS);
        }
    }
}
