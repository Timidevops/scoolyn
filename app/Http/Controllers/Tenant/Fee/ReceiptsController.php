<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    public function index(string $uuid)
    {
        $student = Student::whereUuid($uuid);

        if ( ! $student || ! $student->schoolFee->schoolFeesPaid()){
            abort(404);
        }

        return view('Tenant.pages.fees.student.receipt.index', [
            'transactions' => $student->schoolFee->transactions()->get(),
            'student' => $student,
        ]);
    }
}
