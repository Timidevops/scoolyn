<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolFee;
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

        if($student->schoolFee){
            $studentFees = $student->schoolFee->fee_structure_id;

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
        $this->validate($request, [
            'student' => ['required'],
            'feeStructureId'   => ['required', 'array','min:1']
        ]);

        $student = Student::query()->where('uuid', '=', $request->input('student'))->first();

        $amount = 0;

        foreach($request->input('feeStructureId') as $feeId){
            $feeStructure = FeeStructure::query()->where('uuid', $feeId)->first();
            if(! $feeStructure){
                continue;
            }

            $amount += $feeStructure->amount;

        }

        $schoolFee = (new CreateNewSchoolFeeAction())->execute($student, [
            'amount' => $amount,
            'fee_structure_id' => $request->input('feeStructureId'),
        ]);

        $schoolFee->setStatus(SchoolFee::NOT_PAID_STATUS);

        Session::flash('successFlash', 'Student fee added successfully!!!');

        return back();
    }
}
