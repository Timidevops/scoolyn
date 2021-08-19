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
];
