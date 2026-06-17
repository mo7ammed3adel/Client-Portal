<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'kashier' => [
        'mid' => env('KASHIER_MID'),
        'payment_key' => env('KASHIER_PAYMENT_KEY'),
        'secret_key' => env('KASHIER_SECRET_KEY'),
        'mode' => env('KASHIER_MODE', 'test'),
        'currency' => env('KASHIER_CURRENCY', 'EGP'),
        'checkout_url' => env('KASHIER_CHECKOUT_URL', 'https://checkout.kashier.io'),
        'api_base_url' => env('KASHIER_API_BASE_URL', 'https://test-fep.kashier.io'),
        'allowed_methods' => env('KASHIER_ALLOWED_METHODS', 'card,wallet'),
        'timeout' => (int) env('KASHIER_TIMEOUT', 20),
    ],

    'sms' => [
        'driver' => env('SMS_DRIVER', 'log'),

        'vonage' => [
            'api_key' => env('VONAGE_API_KEY'),
            'api_secret' => env('VONAGE_API_SECRET'),
            'from' => env('VONAGE_FROM', env('APP_NAME', 'ClientPortal')),
        ],

        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        'otp_ttl_seconds' => (int) env('OTP_TTL_SECONDS', 300),
        'otp_max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 3),
        'otp_debug' => (bool) env('OTP_DEBUG', false),
        'otp_fixed_code' => env('OTP_FIXED_CODE', env('OTP_DEBUG', false) ? '123456' : null),
    ],

];
