<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassArm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResultAdditionalCommentsController extends Controller
{
    public function store(Request $request, string $classArmId, string $studentId)
    {
        $this->validate($request, [
            'comment' => ['required'],
        ]);

        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $academicResult = $classArm->academicResult()->where('student_id', $studentId)->firstOrFail();

        $academicResult->update([
            'comment' => $request->input('comment'),
            'principal_remark' => $request->input('principalRemark'),
        ]);

        Session::flash('successFlash', 'Additional comment added successfully!!!');

        return back();
    }
}
