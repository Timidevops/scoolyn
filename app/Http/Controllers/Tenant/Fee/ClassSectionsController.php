<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewClassSectionFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use Illuminate\Http\Request;

class ClassSectionsController extends Controller
{
    public function store(Request $request)
    {
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        (new CreateNewClassSectionFeeAction())->execute($class,[
            'fee_structure_id' => $request->input('feeType'),
        ]);

        return redirect('/');
    }
}
