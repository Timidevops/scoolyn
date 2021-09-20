<?php


namespace App\Actions\Tenant\Payments;


use App\Actions\Tenant\Services\PaymentService;
use App\Models\Tenant\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VerifyFlutterwaveTransactionAction
{
    public function execute(string $transactionId)
    {
        PaymentService::setFlutterwaveSecretKey();
        return \Digikraaft\Flutterwave\Transaction::verify($transactionId);
    }
}
