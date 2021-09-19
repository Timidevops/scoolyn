<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Actions\Tenant\Payments\VerifyFlutterwaveTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CallbackFromCheckoutsController extends Controller
{
    public function update(Request $request)
    {
        $reference = $request->get('tx_ref');

        $transaction = Transaction::query()->where('reference', $reference)->firstOrFail();

        //verify flutterwave transaction
        $flutterwaveResponse = (new VerifyFlutterwaveTransactionAction())->execute($reference);

        if($flutterwaveResponse->status !== 'success'){
            Session::flash('errorFlash', 'Error processing request');

            return redirect()->route('singleWardFee',[
                $transaction->schoolFees->uuid,
                $transaction->schoolFees->student_id
            ]);
        }

        $transaction->update([
            'payment_method_reference' => $flutterwaveResponse->data->id,
        ]);
        $transaction->save();

        if($flutterwaveResponse->data->status != 'successful'){
            Session::flash('warningFlash', 'Payment was not successful. Please try again later.');

            return view('failed')->with([
                'callbackUrl' => '',
            ]);
        }

        //update school fees status
        $transaction->schoolFees->setStatus(SchoolFee::PAID_STATUS);

        Session::flash('successFlash', 'School fees paid successfully!');

        return redirect()->route('singleWardFee',[
            $transaction->schoolFees->uuid,
            $transaction->schoolFees->student_id
        ]);
    }

}
