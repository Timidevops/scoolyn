<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\AcademicReport\CreateNewAcademicReportAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use Illuminate\Http\Request;

class AcademicReportsController extends Controller
{

    public function store(string $uuid)
    {
        $student = Student::query()->where('uuid', '=', $uuid)->first();

        //$request['meta'] = $request->input('reportCard');

        //@todo job := queue
        //(new CreateNewAcademicReportAction())->execute($student, $request->only('meta'));
    }
}
