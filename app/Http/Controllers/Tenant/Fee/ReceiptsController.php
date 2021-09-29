<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSchoolFee;
use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    public function index(string $uuid)
    {
        $student = Student::whereUuid($uuid);

        if ( ! $student || ! (new StudentSchoolFee($student))->schoolFeesPaid()){
            abort(404);
        }

        return view('tenant.pages.fees.student.receipt.index', [
            'transactions' => (new StudentSchoolFee($student))->transactions,
            'student' => $student,
        ]);
    }
}
