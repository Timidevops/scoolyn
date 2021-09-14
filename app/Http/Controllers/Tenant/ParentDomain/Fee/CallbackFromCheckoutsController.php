<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Fee;

use App\Actions\Tenant\Checkout\VerifyCheckoutTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CallbackFromCheckoutsController extends Controller
{
    public function update(Request $request)
    {
        $reference = $request->get('clientReference');

        $transaction = Transaction::query()->where('reference', $reference)->firstOrFail();

        //verify checkout transaction
        $checkoutResponse =  (new VerifyCheckoutTransactionAction)->execute($reference);

        if($checkoutResponse == null || $checkoutResponse['status'] == '422'){
            Session::flash('errorFlash', 'Error processing request');

            return redirect()->route('singleWardFee',[
                $transaction->schoolFees->uuid,
                $transaction->schoolFees->student_id
            ]);
        }

        if($checkoutResponse['status'] == 'processing'){
            Session::flash('warningFlash', 'Processing request');

            return redirect()->route('singleWardFee',[
                $transaction->schoolFees->uuid,
                $transaction->schoolFees->student_id
            ]);
        }

        $transaction->update([
            'payment_method_reference' => $checkoutResponse['transactionReference'],
        ]);

        $transaction->save();

        if($checkoutResponse['status'] != 'succeeded'){
            return view('failed')->with(compact('callbackUrl'));
        }

        //@todo call interbanc webhook to credit wallet // create transaction

        //update school fees status
        $transaction->schoolFees->setStatus(SchoolFee::PAID_STATUS);

        Session::flash('successFlash', 'School fees paid successfully!!!');

        return redirect()->route('singleWardFee',[
            $transaction->schoolFees->uuid,
            $transaction->schoolFees->student_id
        ]);
    }

}
