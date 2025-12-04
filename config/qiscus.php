<?php

return [
    /**
     * ----------------------------------------------------------------
     * API Credentials
     * ----------------------------------------------------------------
     */
    'base_url' => env('QISCUS_BASE_URL', 'https://omnichannel.qiscus.com'),
    'app_id' => env('QISCUS_APP_ID', ''),
    'secret_key' => env('QISCUS_SECRET_KEY', ''),
    'channel_id' => env('QISCUS_CHANNEL_ID', ''),

    'default_language' => [
        'policy' => 'deterministic',
        'code' => 'id', ],

    /**
     * ----------------------------------------------------------------
     * Template Definitions
     * ----------------------------------------------------------------
     */
    'templates' => [

        'otp' => [
            'namespace' => env('QISCUS_OTP_NAMESPACE', ''),
            'name' => env('QISCUS_OTP_TEMPLATE_NAME', ''),
        ],

        'welcome' => [
            'namespace' => env('QISCUS_NOTIFICATION_NAMESPACE', ''),
            'name' => env('QISCUS_TEMPLATE_WELCOME', ''),
        ],

        'submission_accepted' => [
            'namespace' => env('QISCUS_UTILS_ACCEPTED_NAMESPACE', ''),
            'name' => env('QISCUS_UTILS_ACCEPTED_TEMPLATE_NAME', ''),
        ],

        'submission_rejected' => [
            'namespace' => env('QISCUS_UTILS_REJECTED_NAMESPACE', ''),
            'name' => env('QISCUS_UTILS_REJECTED_TEMPLATE_NAME', ''),
        ],
        'password_reset' => [
            'namespace' => env('QISCUS_PASSWORD_RESET_NAMESPACE', ''),
            'name' => env('QISCUS_PASSWORD_RESET_TEMPLATE_NAME', 'forgot_pass_1'),
        ],
    ],

];
