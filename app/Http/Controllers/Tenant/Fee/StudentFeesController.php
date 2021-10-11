<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSchoolFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentFeesController extends Controller
{

    public function index(string $uuid)
    {
        $student = Student::whereUuid($uuid);

        $studentFees = (new StudentSchoolFee($student));

        return view('tenant.pages.fees.student.index', [
            'totalFees' => $studentFees->feesItems()->count(),
            'student' => $student,
            'feeStatus' => $studentFees->status(),
            'studentFees' => $studentFees->schoolFees,
            'feesItems' => $studentFees->feesItems(),
            'feesStructures' => [],//FeeStructure::query()->whereNotIn('uuid', $studentFees)->get(['uuid', 'name', 'amount']),
            'academicSessionInWord' => Setting::getCurrentAcademicCalendarInWord(),

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

        (new CreateNewSchoolFeeAction())->execute($student, [
            'amount' => $amount,
            'fee_structure_id' => $request->input('feeStructureId'),
        ]);

        Session::flash('successFlash', 'Student fee added successfully!!!');

        return back();
    }
}
