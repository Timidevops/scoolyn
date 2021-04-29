<?php

    if(! function_exists('generateUniqueReference')) {
    function generateUniqueReference(int $length = 12, string $prefix = null) : string
    {
        $random_string = random_string($length);
        return $prefix ? $prefix . $random_string : $random_string;
    }
}

if(! function_exists('random_string')) {
    function random_string($length, $keySpace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') : string
    {
        $str = '';
        $max = mb_strlen($keySpace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keySpace[random_int(0, $max)];
        }
        return $str;
    }
}
if(! function_exists('random_number')){
    function random_number(int $min, int $max, int $length)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        $rand = array_slice($numbers, 0, $length);
        return implode("", $rand);
    }
}

if(! function_exists('moneyFormat')){
    function moneyFormat($amount)
    {
        return number_format((float)$amount, 2, '.', '');
    }
}

    if(! function_exists('encrypt')){
        function encrypt($value)
        {
            $iv   = config('env.app.encryption_iv');
            $salt = config('env.app.encryption_salt');

            return openssl_encrypt(
                $value, 'aes-256-cbc', $salt, null, $iv
            );
        }
    }

    if(! function_exists('decrypt')){
        function decrypt($encryptedValue)
        {
            $components    = explode( ':', $encryptedValue );
            $iv            = config('env.app.encryption_iv');
            $encrypted_msg = $components[0];
            $salt          = config('env.app.encryption_salt');

            return openssl_decrypt(
                $encrypted_msg, 'aes-256-cbc', $salt, null, $iv
            );
        }
    }
