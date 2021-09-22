<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewFeeStructureAction;
use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Http\Controllers\Controller;
use App\Models\Support\Support;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\SchoolFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeeStructuresController extends Controller
{
    public function index()
    {
        return view('Tenant.pages.fees.index', [
            'totalFees' => FeeStructure::query()->count(),
            'feesStructures' => FeeStructure::query()->get(['name', 'amount', 'description']),
            'schoolFees' => SchoolFee::with(['feesItems'])->get()->map(function($fee){
                $fee['amount'] = Support::moneyFormat($fee->amount);
                $fee['total_items'] = "- (". $fee->feesItems()->count() ." fee items.)";
                $fee['academic_year'] = $fee->academicSession->session_name;
                return $fee;
            }),
        ]);
    }

    public function create()
    {
        return view('Tenant.pages.fees.create', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
            'schoolTerms' => AcademicTerm::all(),
        ]);
    }

    public function store(Request $request)
    {
        $terms = $request->input('schoolTerm');
        $errors = null;

        foreach ($terms as $term){
            $schoolFee = (new CreateNewSchoolFeeAction())->execute([
                'name' => $request->input('feesName'),
                'amount' => $request->input('feesAmount'),
                'term_id' => $term,
            ], $request->input('fee'), $request->input('schoolClass'));

            if(! $schoolFee){
                $errors = true;
            }
        }

        if($errors){
            Session::flash('errorFlash', 'Fee could not be added');
        }

        Session::flash('successFlash', 'Fee added successfully!!!');

        return back();
    }

    public function edit(string $uuid)
    {
        $schoolFees = SchoolFee::query()->where('uuid', $uuid)->with(['feesItems'])->get();

        if($schoolFees->isEmpty()){
            Session::flash('errorFlash', 'Record not found.');
            return redirect()->route('listFeeStructure');
        }

        return view('Tenant.pages.fees.edit', [
            'schoolFees' => $schoolFees->first(),
        ]);
    }
}
