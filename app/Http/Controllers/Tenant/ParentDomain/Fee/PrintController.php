<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    public function store(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        //dd($ward->schoolFee()->where('uuid', $uuid)->firstOrFail());


        $wardSchoolFee = $ward->schoolFee()->where('uuid', $uuid)->firstOrFail();

        $schoolFees = collect($wardSchoolFee->fee_structure_id)->map(function ($schoolFee){
            return FeeStructure::whereUuid($schoolFee);
        });



        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('Tenant.pdf.fees.receipt',[
            'schoolFees' => $schoolFees,
            'feeDetails' => $wardSchoolFee,
            'ward' => $ward,
            'schoolDetails' => Setting::schoolDetails(),
            'sessionInWord' => Setting::getCurrentAcademicCalendarInWord(),
            'principal' => Setting::getSchoolPrincipal(),
        ]);

        $pdfFile = "receipt-for-{$wardSchoolFee->student->first_name}-{$wardSchoolFee->academicSession->term}-term-{$wardSchoolFee->academicSession->session_name}-session.pdf";


        return $pdf->stream($pdfFile);
    }
}
