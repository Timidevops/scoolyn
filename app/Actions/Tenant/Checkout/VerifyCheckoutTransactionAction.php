<?php


namespace App\Actions\Tenant\Checkout;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VerifyCheckoutTransactionAction
{
    public function execute(string $reference)
    {
        //call checkout endpoint
        $client = new Client(['base_uri' => config('env.checkout.url')]);

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
            //todo add log
            return false;
        }

        return json_decode($response->getBody(),true);

    }
}
