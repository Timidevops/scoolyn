<?php


namespace App\Actions\Tenant\Checkout;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class InitializeCheckoutAction
{
    /**
     * @param array $input
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function execute(array $input)
    {
        //call checkout endpoint
        $client = new Client(['base_uri' => config('env.checkout.url')]);

        try {
            $response = $client->request('POST', '/api/payment-intents',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . config('env.checkout.api_key')
                    ],
                    'form_params' => [
                        'amount'          => $input['amount'],
                        'currency'        => 'ngn',
                        'receiptEmail'    => $input['email'],
                        'clientReference' => $input['reference'],
                        'callbackUrl'     => $input['callbackUrl'],
                    ]
                ]);
        } catch (GuzzleException $e) {
            return false;
        }

        return json_decode($response->getBody(),true)['data']['attributes'];
    }

}
