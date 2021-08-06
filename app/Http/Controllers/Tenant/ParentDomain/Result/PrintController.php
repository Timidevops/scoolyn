<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSubject;
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

        $result->load(['student', 'academicSession', 'academicTerm', 'classArm']);

        $subjects = collect($result->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->subject->subject_name);
        })->values();

        $this->gradeFormats = $result->grading_format;

        $subjects = $subjects->map(function ($subject) use ($result){
            return collect($subject)->merge($this->getGrade($subject['total']));
        });

        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('Tenant.pdf.result.result',[
            'result' => $result,
            'subjects' => $subjects,
        ]);

        $pdfFile = "result-for-{$result->student->first_name}-{$result->academicTerm->term_name}-term-{$result->academicSession->session_name}-session.pdf";


        return $pdf->stream($pdfFile);
    }

    private function getGrade($total)
    {
        $format = collect($this->gradeFormats)->filter(function ($item) use($total){
            return $total >= ($item['from']) && $total <= ($item['to']);
        });

       return [
           'grade' => $format[0]['grade'],
           'gradeRemark' => $format[0]['comment'],
       ];
    }
}
