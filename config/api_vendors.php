<?php

return [
    'myflex' => [
        'base_url' => env('MYFLEX_BASE_URL'),
        'username' => env('MYFLEX_USERNAME'),
        'password' => env('MYFLEX_PASSWORD'),
    ],
    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY')
    ],
    'slack' => [
        'message_hook' => env('SLACK_MESSAGE_HOOK')
    ],
    'flutterwave' => [
        'base_url' => env('FLW_BASE_URL'),
        'token' => env('FLW_TOKEN'),
        'v2' => [
            'base_url' => env('FLW_V2_BASE_URL'),
            'secret_key' => env('FLW_V2_SECRET_KEY'),
            'encryption_key' => env('FLW_V2_ENCRYPTION_KEY'),
            'public_key' => env('FLW_V2_PUBLIC_KEY'),
        ],
        'v3' => [
            'base_url' => env('FLW_V3_BASE_URL'),
            'secret_key' => env('FLW_V3_SECRET_KEY'),
            'encryption_key' => env('FLW_V3_ENCRYPTION_KEY'),
            'public_key' => env('FLW_V3_PUBLIC_KEY'),
        ]
    ],
    'payant' => [
        'base_url' => env('PAYANT_BASE_URL'),
        'token' => env('PAYANT_PRIVATE_KEY')
    ],
];
