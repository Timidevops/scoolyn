<?php
return [
    'app_url' => env('APP_URL'),
    'tenant' => [
        'tenantConnection' => config('multitenancy.tenant_database_connection_name', 'tenant'),
    ],
    'checkout'=> [
        'url' => env('CHECKOUT_BASE_URL'),
        'api_key' => env('CHECKOUT_API_KEY'),
    ],
];
