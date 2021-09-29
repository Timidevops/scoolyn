<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Ward;

use App\Http\Controllers\Controller;
use App\Models\Tenant\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardsController extends Controller
{
    public function index()
    {
        $parent = Auth::user()->parent;

        return view('tenant.parentDomain.ward.index', [
            'totalWards' => $parent->ward()->count(),
            'wards' => $parent->ward,
        ]);
    }

}
