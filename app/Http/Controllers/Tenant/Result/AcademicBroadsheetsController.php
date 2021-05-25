<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use Illuminate\Http\Request;

class AcademicBroadsheetsController extends Controller
{
    public function store(Request $request)
    {
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        if( $request->input('classSectionCategory') ){
            $class = ClassSectionCategory::query()->where('uuid', '=', $request->input('classSectionCategory'))->first();
        }

        (new CreateNewBroadsheetAction())->execute($class, [
            'subject_id' => $request->input('subject'),
            'teacher_id' => $request->input('teacher'),
            'meta'       => $request->input('broadsheet')
        ]);

        //@todo add status

        return redirect('/');
    }
}
