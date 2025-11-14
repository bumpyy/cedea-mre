<?php

return [
    'base_url' => env('QICUS_BASE_URL', 'https://qicus.com/api/v1'),
    'app_id' => env('QICUS_APP_ID', ''),
    'secret_key' => env('QICUS_SECRET_KEY', ''),

    'channel_id' => env('QICUS_CHANNEL_ID', ''),

    'otp_namespace' => env('QICUS_OTP_NAMESPACE', ''),
    'otp_template_name' => env('QICUS_OTP_TEMPLATE_NAME', ''),

    'utils_accepted_namespace' => env('QICUS_UTILS_ACCEPTED_NAMESPACE', ''),
    'utils_accepted_template_name' => env('QICUS_UTILS_ACCEPTED_TEMPLATE_NAME', ''),

    'utils_rejected_namespace' => env('QICUS_UTILS_REJECTED_NAMESPACE', ''),
    'utils_rejected_template_name' => env('QICUS_UTILS_REJECTED_TEMPLATE_NAME', ''),
];
