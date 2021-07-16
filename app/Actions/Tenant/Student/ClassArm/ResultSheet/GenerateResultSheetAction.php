<?php


namespace App\Actions\Tenant\Student\ClassArm\ResultSheet;

use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Model;

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
        $studentBroadsheets =[];
        foreach ($studentIds as $studentId){
            $student = Student::query()->where('uuid', $studentId)->first();

            $studentBroadsheets [$studentId] = (new GetBroadsheetsAction())->execute($classArm->uuid, $studentId, $student->subjects->subjects);
        }

        if( count($studentIds) != count($studentBroadsheets) ){
            //@todo add log
            return;
        }

        $this->studentBroadsheets = $studentBroadsheets;

        $this->studentBroadsheets = $this->updateStudentBroadsheetsWithStudentPosition();

        $this->updateStudentBroadsheetWithStudentMetric();

        // add data to resultTable of each student
        //@todo add ca and grading format...
        foreach ( $this->studentBroadsheets as $key => $studentBroadsheet ){
            $input = $studentBroadsheet;

            $input['student_id'] = $key;

            $input['class_arm'] = (string) $classArm->uuid;

            $result = (new CreateNewResultSheetAction())->execute(camel_to_snake($input));

            $result->setStatus(AcademicResult::PENDING_RESULT_STATUS);
        }

        //check if result generated equals to number of students in class
        if( count($classArm->academicResult) !=  count($studentIds) ){

            //@todo log

            $classArm->setStatus(ClassArm::RESULT_INCOMPLETE_STATUS);

            return;
        }

        $classArm->setStatus(ClassArm::RESULT_GENERATED_STATUS);
    }

    private function updateStudentBroadsheetsWithStudentPosition()
    {
        $totalMarkObtained = [];

        foreach ($this->studentBroadsheets as $key => $studentBroadsheet){
            $totalMarkObtained [$key] = $studentBroadsheet['totalMarkObtained'];
        }

        arsort($totalMarkObtained);

        $position = 1;

        foreach ($totalMarkObtained as $key =>  $value){

            $searchKey = array_search($value, $totalMarkObtained);

            //scenario; if same position retain position.
            if ($key !=  $searchKey) {
                $studentBroadsheet = collect($this->studentBroadsheets)->get($key);

                $duplicatePosition = $position - 1;

                $this->studentBroadsheets[$key] = collect($studentBroadsheet)->put('classPosition', (string) $duplicatePosition)->toArray();

                continue;
            }

            $studentBroadsheet = collect($this->studentBroadsheets)->get($key);

            $this->studentBroadsheets[$key] = collect($studentBroadsheet)->put('classPosition', (string) $position)->toArray();

            $position++;
        }

        return $this->studentBroadsheets;

    }

    private function updateStudentBroadsheetWithStudentMetric()
    {

        foreach ($this->studentBroadsheets as $key => $broadsheet){
            //dd($broadsheet);
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
}
