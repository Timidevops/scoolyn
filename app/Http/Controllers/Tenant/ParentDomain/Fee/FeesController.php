<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use App\Models\Tenant\SchoolFee;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    public function index(Request $request)
    {
        //@todo change to auth parent...
        $parent = Parents::find(1);

        $wards  =  $parent->ward()->get('uuid')->toArray();

        $schoolFees = SchoolFee::query()->where('student_id', $wards)->get();

        //dd($request->has('ward'));

        return view('livewire.tenant.parent-domain.fees.index', [
            'schoolFees' => SchoolFee::query()->get(),
        ]);
    }
}
