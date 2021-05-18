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

if(! function_exists('camel_to_snake')){
    /**
     *
     * @param array | string $input
     * @return array | string
     */
    function camel_to_snake($input)
    {
        if(! is_array($input)){
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            return implode('_', $ret);
        }
        $newInput = array();
        foreach ($input as $key => $inputs){
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $key, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            $index = implode('_', $ret);
            $newInput[$index] = $inputs;
        }

        return $newInput;

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
