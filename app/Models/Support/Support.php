<?php


    namespace App\Models\Support;


    class Support
    {
        public static function moneyFormat(float $amount, string $currency = null): string
        {
            $money = number_format($amount, 2, '.', ',');
            if($currency){
                return $currency . $money;
            }
            return $money;
        }
    }
