<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewStudentFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentFeesController extends Controller
{

    public function index(string $uuid)
    {
        $student = Student::whereUuid($uuid);

        $fees = collect([]);

        $studentFees = collect([]);

        if($student->studentFee){
            $studentFees = $student->studentFee->fee_structure_id;

            $fees = FeeStructure::query()->whereIn('uuid', $studentFees)->get();
        }

        return view('Tenant.pages.fees.student.index', [
            'totalFees' => $fees->count(),
            'student' => $student,
            'studentFees' => $fees,
            'feesStructures' => FeeStructure::query()->whereNotIn('uuid', $studentFees)->get(['uuid', 'name', 'amount']),
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::query()->where('uuid', '=', $request->input('student'))->first();

        (new CreateNewStudentFeeAction())->execute($student, [
            'fee_structure_id' => $request->input('feeStructureId'),
        ]);

        Session::flash('successFlash', 'Student fee added succesfully!!!');

        return back();
    }
}
