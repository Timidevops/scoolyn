<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class PrintResultController extends Controller
{
    private $gradeFormats;
    private $studentResult;

    public function store(string $classArmId, string $uuid, string $studentId, Request $request)
    {
        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        if ( ! $classArm->hasStudent($studentId) ){
            abort(404);
        }

        $student = Student::whereUuid($studentId);

        if ( $request->has('session') ){

            $this->studentResult = $student->academicSessionResult()->where('uuid', $uuid)->firstOrFail();

            $pdf = App::make('dompdf.wrapper');

            $pdf->loadView('Tenant.pdf.result.sessionResult',[
                'result' => $this->studentResult,
                'subjects' => $this->getSubjects(),
                'schoolDetails' => Setting::schoolDetails(),
                'session' => AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId()),
                'principal' => Setting::getSchoolPrincipal(),
            ]);

            $pdfFile = "result-for-{$this->studentResult->student->first_name}-{$this->studentResult->academicSession->session_name}-session.pdf";

            return $pdf->download($pdfFile);
        }

        $this->studentResult = $student->academicReport()->where('uuid', $uuid)->firstOrFail();

        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('Tenant.pdf.result.result',[
            'result' => $this->studentResult,
            'subjects' => $this->getSubjects(),
            'schoolDetails' => Setting::schoolDetails(),
            'sessionInWord' => Setting::getCurrentAcademicCalendarInWord(),
            'principal' => Setting::getSchoolPrincipal(),
        ]);

        $pdfFile = "result-for-{$this->studentResult->student->first_name}-{$this->studentResult->academicSession->getTerm['name']}-term-{$this->studentResult->academicSession->session_name}-session.pdf";

        return $pdf->download($pdfFile);
    }

    private function getSubjects()
    {
        $this->studentResult->load(['student', 'academicSession', 'classArm']);

        $subjects = collect($this->studentResult->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->first()->subject->subject_name);
        })->values();

        $this->gradeFormats = $this->studentResult->grading_format;

        return $subjects = $subjects->map(function ($subject){
            return collect($subject)->merge($this->getGrade($subject['subjectMetric']['total']));
        });
    }

    private function getGrade($total)
    {
        $format = collect($this->gradeFormats)->filter(function ($item) use($total){
            return $total >= ($item['from']) && $total <= ($item['to']);
        });

        return [
            'grade' => $format[0]['grade'],
            'gradeRemark' => $format[0]['comment'],
            'color' => $format[0]['color']
        ];
    }

}
