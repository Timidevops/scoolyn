<?php


    namespace App\Actions\Tenant\Services;


    use Digikraaft\Flutterwave\Flutterwave;

    class PaymentService
    {
        public static function setFlutterwaveSecretKey()
        {
            Flutterwave::setApiKey(config('env.payments.flutterwave.flutterwave_secret_key'));
        }
    }
