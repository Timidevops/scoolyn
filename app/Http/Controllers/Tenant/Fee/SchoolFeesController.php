<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassFee;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentFee;
use Illuminate\Http\Request;

class SchoolFeesController extends Controller
{

    public function store(string $uuid, Request $request)
    {
        $student = Student::query()->where('uuid','=', $uuid)->first();

        $classFee   = 0;
        $studentFee = 0;

        if ( $request->input('classFee') ){
           $classFeeModel = ClassFee::query()->where('uuid', '=', $request->input('classFee'))->first();
           $classFee = $classFeeModel->feeStructure->amount;
        }

        if ( $request->input('studentFee') ){

            $studentFeeLength = count($request->input('studentFee'));

            for( $int = 0; $int < $studentFeeLength; $int++ ){
                $studentFeeModel = StudentFee::query()->where('uuid', '=', $request->input('studentFee')[$int])->first();
                $studentFee += $studentFeeModel->feeStructure->amount;
            }
        }

        (new CreateNewSchoolFeeAction())->execute($student, [
            'amount' => $classFee + $studentFee,
        ]);

        //@todo add status

        return redirect('/');
    }
}
