<?php

namespace App\Http\Controllers\Tenant\Setting\Subscripton\Addon;

use App\Actions\Tenant\Checkout\VerifyCheckoutTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Landlord\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutCallbackController extends Controller
{
    public function store(Request $request)
    {
        $reference = $request->get('clientReference');

        $transaction = Transaction::whereReference($reference)->firstOrFail();

        //verify checkout transaction
        $response = (new VerifyCheckoutTransactionAction)->execute($reference);

        if ( ! $response || $response['status'] == '422' ){
            Session::flash('errorFlash', 'Error processing response, contact support.');

            return redirect()->route('subscriptionStudentAddon');
        }

        if ( $response['status'] == 'processing' ){
            Session::flash('warningFlash', 'Processing payment');

            return redirect()->route('subscriptionStudentAddon');
        }

        $transaction->update([
            'payment_method_reference' => $response['transactionReference'],
        ]);

        if ( $response['status'] != 'succeeded' ){
            Session::flash('errorFlash', 'Error processing payments.');

            return redirect()->route('subscriptionStudentAddon');
        }

        //@todo add plan subscription addon

        Session::flash('successFlash', 'Student Addon added to subscription successfully!!!');

        return redirect()->route('subscriptionSetting');
    }
}
