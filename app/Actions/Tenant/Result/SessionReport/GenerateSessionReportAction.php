<?php


namespace App\Actions\Tenant\Result\SessionReport;

use App\Actions\Tenant\Result\Helpers\GetSubjectMetricAction;
use App\Actions\Tenant\Result\Helpers\UpdateStudentBroadsheetsOrStudentReportWithStudentPosition;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\AcademicSessionResult;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GenerateSessionReportAction
{
    private Model $classArm;

    private array $overallStudentsReport = [];

    public function execute(Model $classArm)
    {
        $this->classArm = $classArm;

        $lastReport = ReportCardBreakdownFormat::all()->last();

        $studentIds = $classArm->students;

        $classSubjectIds = $classArm->classSubject->map(function ($classSubject){
            return $classSubject->uuid;
        });

        $students = [];

        foreach ($studentIds as $studentId){

            $student = Student::whereUuid($studentId);

            $studentAcademicReports = $student->academicReport()->withoutGlobalScope('resultSession')
                ->where('report_card', $lastReport->uuid)
                ->get();

            $subjectTotalPerTerm = collect($studentAcademicReports)->map(function ($academicReport){
                return $this->getSubjectTotalPerTerm($academicReport->subjects);
            });

            $subjects = collect($classSubjectIds)->map(function ($id) use ($subjectTotalPerTerm){

                foreach ($subjectTotalPerTerm as $index => $score){
                    $term = $index + 1;
                    $subjectTotals[$id]["{$term}_term"] = collect($score)->first();
                }

                $subjectTotals [$id]['overallTermTotalAvg'] = collect($subjectTotalPerTerm)->map(function ($term) use ($id){
                        return $term[$id];
                    })->sum() / 3;

                return $subjectTotals;
            })->first();

            $students [$studentId]['subjects'] = $subjects;
            $students [$studentId]['totalMarkObtained'] = collect($subjects)->map(function ($item){return $item['overallTermTotalAvg'];})->sum();
            $students [$studentId]['totalMarkAttainable'] = count($subjects) * 100;
        }

        $this->overallStudentsReport = $students;

        //update student with overall position
        $this->overallStudentsReport  = (new UpdateStudentBroadsheetsOrStudentReportWithStudentPosition)->execute($this->overallStudentsReport);

        $studentSubject = collect($students)->map(function ($student){
            return $student['subjects'];
        })->toArray();

        //update student with subject metrics
        $subjectMetrics = collect($classSubjectIds)->map(function ($id) use($studentSubject){
            $subjectScores = collect($studentSubject)->map(function ($subject) use($id){
                return collect($subject)->get($id)['overallTermTotalAvg'];
            })->toArray();

            $subject [$id] = (new GetSubjectMetricAction)->execute($subjectScores);
            return $subject;
        })->first();

        collect($this->overallStudentsReport)->map(function ($item, $studentId) use($subjectMetrics){
            collect($item['subjects'])->map(function ($item, $subjectId) use ($subjectMetrics, $studentId){
                $metrics = collect($subjectMetrics[$subjectId])->get($studentId);
               $this->overallStudentsReport[$studentId]['subjects'][$subjectId] =
                   collect($this->overallStudentsReport[$studentId]['subjects'][$subjectId])->put('subjectMetric',$metrics)->toArray();
            });
        });

        //add data to sessionResultTable of each student
        try{
            DB::beginTransaction();
                foreach ($this->overallStudentsReport as $key => $studentReport){
                    $input = $studentReport;

                    $input['class_arm'] = (string) $classArm->uuid;

                    $input['studentId'] = $key;

                    $input['caFormat'] = $this->getCaFormat();

                    $input['gradingFormat'] = $this->getGradingFormat();

                    $report = (new CreateNewAcademicSessionReportAction)->execute(camel_to_snake($input));

                    $report->setStatus(AcademicSessionResult::PENDING_STATUS);
                }
            DB::commit();
        }
        catch (\Exception $exception){
            //@todo logo
            $classArm->setStatus(ClassArm::SESSION_REPORT_ERROR_STATUS);
            DB::rollBack();
            return;
        }

        $classArm->setStatus(ClassArm::SESSION_REPORT_GENERATED_STATUS);
    }

    private function getSubjectTotalPerTerm(array $subjects)
    {
        return collect($subjects)->map(function ($subject){
            return $subject['subjectMetric']['total'];
        })->toArray();
    }

    private function getGradingFormat()
    {
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        $gradeFormats = collect($gradeFormats->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        return $gradeFormats['gradingFormat'];
    }

    private function getCaFormat()
    {
        $gradeFormats = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        $gradeFormats = collect($gradeFormats->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        return $gradeFormats['caFormat'];
    }

}
