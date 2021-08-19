<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Plan;
use App\Models\Landlord\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionPaymentsController extends Controller
{
    public function create(string $uuid)
    {
        $plan = Plan::query()->where('uuid', $uuid)->firstOrFail();

        return view('Landlord.pages.payment.index', [
            'plan' => $plan,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'planId'  => ['required', "exists:App\Models\Landlord\Plan,uuid"],
            'email' => ['required', 'email'],
        ]);

        //get subscription
        $subscription = Plan::query()->where('uuid', $request->input('planId'))->first();

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
                        'receiptEmail'    => $request->input('email'),
                        'clientReference' => $reference,
                        'callbackUrl'     => config('env.app_url') . '/checkout/payment/call-back',
                    ]
                ]);
        } catch (GuzzleException $e) {
            Session::flash('errorFlash', 'Error processing request');
            return back();
        }

        //create landlord transaction
        $this->createNewTransaction([
            'reference' => $reference,
            'amount' => $subscription->price,
            'currency' => 'ngn',
            'subscription_id' => $subscription->id,
            'user_reference' => $request->input('email'),
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
