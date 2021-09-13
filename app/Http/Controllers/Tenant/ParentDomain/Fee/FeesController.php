<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Actions\Tenant\Transaction\CreateNewTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesController extends Controller
{
    public function index(Request $request)
    {
        $parent = Auth::user()->parent;

        $wards  =  $parent->ward()->get('uuid')->toArray();

        $schoolFees = SchoolFee::query()->whereIn('student_id', $wards)->get();

        $schoolFees->load(['student', 'academicSession']);

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

    public function store(string $uuid, string $studentId)
    {
        $parent = Auth::user()->parent;

        $ward = $parent->ward()->where('uuid', $studentId)->first() ?? false;

        $wardSchoolFee = $ward ? $ward->schoolFee()->where('uuid', $uuid)->first() : false;

        if( ! $ward || ! $wardSchoolFee ){
            Session::flash('errorFlash', 'Error processing request');

            return back();
        }

        //call checkout endpoint
        $client = new Client(['base_uri' => env('CHECKOUT_BASE_URL')]);

        $reference = generateUniqueReference('12','rp_');

        try {
            $response = $client->request('POST', '/api/payment-intents',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('CHECKOUT_API_KEY')
                    ],
                    'form_params' => [
                        'amount'          => $wardSchoolFee->amount,
                        'currency'        => 'ngn',
                        'receiptEmail'    => $parent->email,
                        'clientReference' => $reference,
                        'callbackUrl'     => env('APP_URL') . '/payment/call-back',
                    ]
                ]);
        } catch (GuzzleException $e) {

            Session::flash('errorFlash', 'Error processing request');
            return back();
        }

        $responseData = (json_decode($response->getBody(),true)['data']['attributes']);

        $redirectTo   =  $responseData['checkoutLink'];

        //create transaction
        (new CreateNewTransactionAction())->execute([
            'reference'      => $reference,
            'type'           => Transaction::CREDIT_TYPE,
            'amount'         => $wardSchoolFee->amount,
            'user_id'        => (string) $parent->uuid,
            'school_fees_id' => $wardSchoolFee->uuid,
            'currency'       => 'ngn',
            'description'    => 'payment for school fees'
        ]);

        return redirect()->to($redirectTo);
    }
}
