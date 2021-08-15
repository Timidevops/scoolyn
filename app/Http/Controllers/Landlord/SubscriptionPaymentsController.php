<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionPaymentsController extends Controller
{
    public function store(Request $request)
    {
        //@todo get subscription
        $subscription = Plan::find(1);

        //call checkout endpoint
        $client = new Client(['base_uri' => config('env.checkout.url')]);

        $reference = generateUniqueReference('12','rp_');

        try {
            $response = $client->request('POST', '/api/payment-intents',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . config('env.checkout.api_key')
                    ],
                    'form_params' => [
                        'amount'          => $subscription->price,
                        'currency'        => 'ngn',
                        'receiptEmail'    => 'abc@gmail.com',//$request->input('email'),
                        'clientReference' => $reference,
                        'callbackUrl'     => config('env.app_url') . '/checkout/payment/call-back',
                    ]
                ]);
        } catch (GuzzleException $e) {
            Session::flash('errorFlash', 'Error processing request');
            dd($e);
            return back();
        }

        //create landlord transaction
        $this->createNewTransaction([
            'reference' => $reference,
            'amount' => $subscription->price,
            'currency' => 'ngn',
            'subscription_id' => $subscription->id,
            'user_reference' => 'abc@gmail.com',//$request->input('email'),
        ]);

        $responseData = (json_decode($response->getBody(),true)['data']['attributes']);

        $redirectTo   =  $responseData['checkoutLink'];

        return redirect()->to($redirectTo);
    }

    private function createNewTransaction(array $input)
    {
        Transaction::query()->create($input);
    }
}
