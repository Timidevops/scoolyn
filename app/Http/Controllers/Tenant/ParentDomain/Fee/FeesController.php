<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\Parents;
use App\Models\Tenant\SchoolFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeesController extends Controller
{
    public function index(Request $request)
    {
        $parent = Auth::user()->parent;

        $wards  =  $parent->ward()->get('uuid')->toArray();

        $schoolFees = SchoolFee::query()->whereIn('student_id', $wards)->get();

        $schoolFees->load(['student', 'academicSession', 'academicTerm']);

        return view('livewire.tenant.parent-domain.fees.index', [
            'schoolFees' => $schoolFees,
            'filterSchoolFees' => $request->has('ward') ? $request->has('ward') : '',
        ]);
    }

    public function single(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        $wardSchoolFee = $ward->schoolFee()->where('uuid', $uuid)->firstOrFail();

        $schoolFees = collect($wardSchoolFee->fee_structure_id)->map(function ($schoolFee){
            return FeeStructure::whereUuid($schoolFee);
        });

        return view('Tenant.parentDomain.fees.single', [
            'wardSchoolFee' => $wardSchoolFee,
            'schoolFees' => $schoolFees,
        ]);
    }
}
