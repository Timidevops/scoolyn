<?php

namespace App\Http\Controllers\Tenant\Student;

use App\Actions\Tenant\Parent\CreateNewParentAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function store(Request $request)
    {
        if( $request->input('parent') ){
            $parent = Parents::query()->where('uuid', '=', $request->input('parent'))->first();
        }
        else{
            //create new parent action
          $parent =  (new CreateNewParentAction())->execute([
              'full_name' => $request->input('parentFullName'),
          ]);
        }

        $request['school_class_id']           = $request->input('class');
        $request['class_section_id']          = $request->input('classSection');
        $request['class_section_category_id'] = $request->input('classSectionCategory') ?? null;

        (new CreateNewStudentAction())->execute($parent, camel_to_snake($request->except([
            '_token', 'parent', 'class', 'classSection', 'classSectionCategory', 'parentFullName'
        ])));

        return redirect('/');
    }
}
