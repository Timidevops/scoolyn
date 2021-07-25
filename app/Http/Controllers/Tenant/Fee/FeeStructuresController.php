<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewFeeStructureAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolClass;
use Illuminate\Http\Request;

class FeeStructuresController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.fees.index', [
            'totalFees' => FeeStructure::query()->count(),
            'feesStructures' => FeeStructure::query()->get(['name', 'amount', 'description']),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.fees.create');
    }

    public function store(Request $request)
    {
        foreach( $request->input('fee') as $fee ){
            (new CreateNewFeeStructureAction())->execute(camel_to_snake($fee));
        }

        return back();
    }
}
