<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;

use App\Actions\Tenant\Result\Helpers\UpdateStudentBroadsheetsOrStudentReportWithStudentPosition;
use App\Jobs\Tenant\GenerateSessionResultJob;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GenerateResultSheetAction
{
    private Model $classArm;
    private array $studentBroadsheets;

    public function execute(Model $classArm)
    {
        $this->classArm = $classArm;

        //get class students
        $studentIds = $classArm->students;

        //get each student subject broadsheet
        $studentBroadsheets = [];
        foreach ($studentIds as $studentId){
            $student = Student::query()->where('uuid', $studentId)->first();

            $studentBroadsheets [$studentId] = (new GetBroadsheetsAction())->execute($classArm->uuid, $studentId, $student->subjects->subjects);
        }

        if( count($studentIds) != count($studentBroadsheets) ){
            //@todo add log
            return;
        }

        $this->studentBroadsheets = $studentBroadsheets;

        $this->studentBroadsheets = (new UpdateStudentBroadsheetsOrStudentReportWithStudentPosition)->execute($this->studentBroadsheets);//$this->updateStudentBroadsheetsWithStudentPosition();

        $this->updateStudentBroadsheetWithStudentMetric();

        //add data to resultTable of each student

        try{
            DB::beginTransaction();

            foreach ( $this->studentBroadsheets as $key => $studentBroadsheet ){
                $input = $studentBroadsheet;

                $input['studentId'] = $key;

                $input['classArm'] = (string) $classArm->uuid;

                $input['gradingFormat'] = $this->getGradingFormat();

                $result = (new CreateNewResultSheetAction())->execute(camel_to_snake($input));

                $result->setStatus(AcademicResult::PENDING_RESULT_STATUS);
            }

            //check if result generated equals to number of students in class
            if( count($classArm->academicResult
                    ->where('class_arm', $this->classArm->uuid)
                    ->where('report_card', Setting::getCurrentCardBreakdownFormat())) !=  count($studentIds) ){

                //@todo log
                DB::rollBack();

                $classArm->setStatus(ClassArm::RESULT_ERROR_STATUS);

                return;
            }

            DB::commit();
        }
        catch (\Exception $exception){
            //@todo log
            DB::rollBack();

            $classArm->setStatus(ClassArm::RESULT_ERROR_STATUS);

            return;
        }

        $classArm->setStatus(ClassArm::RESULT_GENERATED_STATUS);

        $lastTerm = AcademicTerm::all()->last();

        $currentSession = AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId());

        if ( $currentSession->term == $lastTerm->uuid){
            GenerateSessionResultJob::dispatch($classArm);
        }
    }

    private function updateStudentBroadsheetsWithStudentPosition()
    {
        $totalMarkObtained = [];

        foreach ($this->studentBroadsheets as $key => $studentBroadsheet){
            $totalMarkObtained [$key] = $studentBroadsheet['totalMarkObtained'];
        }

        $positions = getPosition($totalMarkObtained, 'classPosition');

        collect($positions)->map(function ($item, $key){

            $studentBroadsheet = collect($this->studentBroadsheets)->get($key);

            $this->studentBroadsheets[$key] = collect($studentBroadsheet)->put('classPosition', (string) $item['classPosition'])->toArray();
        });

        return $this->studentBroadsheets;

    }

    private function updateStudentBroadsheetWithStudentMetric()
    {

        foreach ($this->studentBroadsheets as $key => $broadsheet){
            $this->getSubjectMetric($key, $broadsheet['subjects']);
        }

        return $this->studentBroadsheets;
    }

    private function getSubjectMetric($studentId, array $subjectIds)
    {
        $subjectMetrics =  (new EvaluateSubjectMetricsAction())->execute($this->classArm);

        foreach ($subjectIds as $key => $subjectId){

            $subjectMetric = collect( collect( $subjectMetrics )->get($key) )->get($studentId) ;

            $this->studentBroadsheets[$studentId]['subjects'][$key] = (collect($this->studentBroadsheets[$studentId]['subjects'][$key]))
                ->put('subjectMetric', $subjectMetric)->toArray();
        }
    }

    private function getGradingFormat()
    {
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        $gradeFormats = collect($gradeFormats->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        return $gradeFormats['gradingFormat'];
    }
}
