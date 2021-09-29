<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Actions\Tenant\Checkout\InitializeCheckoutAction;
use App\Actions\Tenant\Transaction\CreateNewTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Support\Support;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesController extends Controller
{
    public function index(Request $request)
    {
        if(Setting::getCurrentAcademicSession()->getTerm()->doesntExist()){
            Session::flash('errorFlash', 'No fees have been set for the current term.');
            return back();
        }
        $parent = Auth::user()->parent;
        $wards = $parent->ward->map(function ($student){
            $schoolFee = $student->classArm->schoolClass->schoolFees()->where('term_id', Setting::getCurrentAcademicSession()->getTerm->uuid)->get()->first();

            if( ! $schoolFee ){
                return  [];
            }

            $student['fee_amount'] = Support::moneyFormat($schoolFee->amount);
            $student['school_fee_id'] = $schoolFee->uuid;
            return $student;
        });

        return view('livewire.tenant.parent-domain.fees.index', [
            'schoolFees' => $wards,
            'filterSchoolFees' => $request->has('ward') ? $request->has('ward') : '',
        ]);
    }

    public function single(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();
        $wardSchoolFee = $ward->classArm->schoolClass->schoolFees;
        $schoolFees = $wardSchoolFee->feesItems;
        $reference = generateUniqueReference('12','rp_');

        return view('tenant.parentDomain.fees.single', [
            'wardSchoolFee' => $wardSchoolFee,
            'schoolFees' => $schoolFees,
            'reference' => $reference,
            'ward' => $ward,
            'payments' => $wardSchoolFee->transactions()->whereNotNull('payment_method_reference')->get(),
        ]);
    }

    public function store(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;
        $ward = $parent->ward()->where('uuid', $studentId)->first() ?? false;
        $wardSchoolFee = $ward ? $ward : false;

        if( ! $ward || ! $wardSchoolFee ){
            Session::flash('errorFlash', 'Error processing request');
            return back();
        }

        $reference = generateUniqueReference('12','rp_');
        //create transaction
        (new CreateNewTransactionAction())->execute([
            'reference'      => $reference,
            'type'           => Transaction::CREDIT_TYPE,
            'amount'         => $wardSchoolFee->amount,
            'user_id'        => (string) $parent->uuid,
            'school_fees_id' => $wardSchoolFee->uuid,
            'currency'       => 'ngn',
            'description'    => 'payment for school fees',
            'meta' => [
                'student_id' => $ward->uuid,
            ],
        ]);

        return response(json_encode([
            'public_key' => config('env.payments.flutterwave.public_key'),
            'reference' => $reference,
            'amount' => $wardSchoolFee->amount,
            'redirect_url' => route('getSchoolFeesCallback'),
            'meta' => [
                'school_name' => Setting::whereSettingName('school_name')->first()->setting_value,
                'student_id' => $ward->uuid,
                'student_name' => "{$ward->first_name} {$ward->last_name}",
                'academic_session' => $wardSchoolFee->academicSession->session_name,
                'fee_structure_id' => $wardSchoolFee->fee_structure_id,
                'transaction_ref' => $reference,
            ],
            'customer' => [
                'email' => $parent->email ?? null,
                'phone' => $parent->phone_number ?? null,
                'name' => "{$parent->first_name} {$parent->last_name}",
            ],
            'subaccounts' => [
                [
                    'id' => Setting::whereSettingName('flutterwave_sub_account_ref')->first()->setting_value
                ]
            ],
            'customizations' => [
                'title' => config('app.name'),
                'description' => "School fees payment for {$ward->first_name} {$ward->last_name}",
                'logo' => 'https://scoolyn.com/images/scoolyn.png',
            ],
        ]));
    }
}
