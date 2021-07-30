<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Ward;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Parents;
use Illuminate\Http\Request;

class WardsController extends Controller
{
    public function index()
    {
        //@todo change to auth parent...
        $parent = Parents::find(1);

        return view('Tenant.parentDomain.ward.index', [
            'totalWards' => $parent->ward()->count(),
            'wards' => $parent->ward,
        ]);
    }

}
