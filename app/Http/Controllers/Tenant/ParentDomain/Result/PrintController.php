<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    private $gradeFormats;

    public function store(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        $result = $ward->academicReport()->where('uuid', $uuid)->firstOrFail();

        $result->load(['student', 'academicSession', 'classArm']);

        $subjects = collect($result->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->first()->subject->subject_name);
        })->values();

        $this->gradeFormats = $result->grading_format;

        $subjects = $subjects->map(function ($subject) use ($result){
            return collect($subject)->merge($this->getGrade($subject['subjectMetric']['total'] ?? $subject['overallTermTotalAvg']));
        });

        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('tenant.pdf.result.result',[
            'result' => $result,
            'subjects' => $subjects,
            'schoolDetails' => Setting::schoolDetails(),
            'sessionInWord' => Setting::getCurrentAcademicCalendarInWord(),
            'principal' => Setting::getSchoolPrincipal(),
        ]);

        $pdfFile = "result-for-{$result->student->first_name}-{$result->academicSession->term}-term-{$result->academicSession->session_name}-session.pdf";


        return $pdf->download($pdfFile);
    }

    private function getGrade($total)
    {
        $format = collect($this->gradeFormats)->filter(function ($item) use($total){
            return $total >= ($item['from']) && $total <= ($item['to']);
        });

       return [
           'grade' => $format[0]['grade'],
           'gradeRemark' => $format[0]['comment'],
           'color' => $format[0]['color'],
       ];
    }
}
