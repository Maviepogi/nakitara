<?php

return [

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    // Google OAuth configuration
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'), // GOOGLE_CLIENT_ID=your-google-client-id
        'client_secret' => env('GOOGLE_CLIENT_SECRET'), // GOOGLE_CLIENT_SECRET=your-google-client-secret
        'redirect' => env('GOOGLE_REDIRECT_URI'), // GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
    ],

];
