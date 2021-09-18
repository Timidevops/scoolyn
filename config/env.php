<?php
return [
    'app_url' => env('APP_URL'),
    'app_domain' => env('APP_DOMAIN'),
    'tenant' => [
        'tenantConnection' => env('DB_CONNECTION_TENANT'),
    ],
    'landlord' => [
        'landlordConnection' => env('DB_CONNECTION'),
    ],
    'checkout'=> [
        'url' => env('CHECKOUT_BASE_URL'),
        'api_key' => env('CHECKOUT_API_KEY'),
    ],
    'payments' => [
        'currency' => env('DEFAULT_CURRENCY', 'NGN'),
        'flutterwave' => [
            'flutterwave_secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
            'split_value' => env('FLUTTERWAVE_SPLIT_VALUE','100'),
            'split_type' => env('FLUTTERWAVE_SPLIT_TYPE','flat'),
        ],
    ],
];
