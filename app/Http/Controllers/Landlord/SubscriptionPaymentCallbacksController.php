<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\SchoolAdmin;
use App\Models\Landlord\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class SubscriptionPaymentCallbacksController extends Controller
{
    public function update(Request $request)
    {
        $reference = $request->get('clientReference');

        $transaction = Transaction::query()->where('reference', $reference)->firstOrFail();

        //verify transaction from checkout
        $checkoutResponse = $this->verifyCheckoutTransaction($reference);

        if($checkoutResponse == null || $checkoutResponse['status'] == '422'){
            return view('');
        }

        if($checkoutResponse['status'] == 'processing'){
            return view('');
        }

        $transaction->update([
            'payment_method_reference' => $checkoutResponse['transactionReference'],
        ]);

        $transaction->save();

        if($checkoutResponse['status'] != 'succeeded'){
            return view('');
        }

        //create school admin
        $schoolAdmin = $this->createNewSchoolAdmin([
            'uuid' => (string) Uuid::uuid4(),
            'email' => $transaction->user_reference,
            'initial_plan' => $transaction->subscription_id
        ]);

        //@todo send email to school admin

        return redirect()->route('appOnboarding', $schoolAdmin->uuid);
    }

    private function verifyCheckoutTransaction(string $reference)
    {
        $client  = new Client(['base_uri' => config('env.checkout.url')]);

        $response = null;
        try {
            $response = $client->request('POST', '/api/payment-intents/verify-transaction',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . config('env.checkout.api_key')
                    ],
                    'form_params' => [
                        'clientReference' => $reference,
                    ]
                ]);
        } catch (GuzzleException $e) {
            return null;
        }
        return json_decode($response->getBody(),true);
    }

    private function createNewSchoolAdmin(array $input)
    {
        return SchoolAdmin::query()->create($input);
    }
}
