<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewStudentFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

class StudentFeesController extends Controller
{

    public function store(Request $request)
    {
        $student = Student::query()->where('uuid', '=', $request->input('student'))->first();

        (new CreateNewStudentFeeAction())->execute($student, [
            'fee_structure_id' => $request->input('feeType'),
        ]);

        return redirect('/');
    }
}
