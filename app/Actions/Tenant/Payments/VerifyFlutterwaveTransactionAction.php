<?php


namespace App\Actions\Tenant\Payments;


use App\Actions\Tenant\Services\PaymentService;
use App\Models\Tenant\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VerifyFlutterwaveTransactionAction
{
    public function execute(string $reference)
    {
        PaymentService::setFlutterwaveSecretKey();
        $transaction = Transaction::query()->where('reference','=', $reference)->first();
        return \Digikraaft\Flutterwave\Transaction::verify($transaction->payment_method_reference);
    }
}
