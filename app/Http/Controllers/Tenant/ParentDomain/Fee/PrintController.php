<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    public function store(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        $wardSchoolFee = $ward->schoolFee()->where('uuid', $uuid)->firstOrFail();

        $schoolFees = collect($wardSchoolFee->fee_structure_id)->map(function ($schoolFee){
            return FeeStructure::whereUuid($schoolFee);
        });

        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('Tenant.pdf.fees.receipt',[
            'schoolFees' => $schoolFees,
            'feeDetails' => $wardSchoolFee
        ]);

        $pdfFile = "receipt-for-{$wardSchoolFee->student->first_name}-{$wardSchoolFee->academicTerm->term_name}-term-{$wardSchoolFee->academicSession->session_name}-session.pdf";


        return $pdf->stream($pdfFile);
    }
}
