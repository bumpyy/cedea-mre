<?php

return [
    'base_url' => env('QICUS_BASE_URL', 'https://qicus.com/api/v1'),
    'app_id' => env('QICUS_APP_ID', null),
    'secret_key' => env('QICUS_SECRET_KEY', null),

    'channel_id' => env('QICUS_CHANNEL_ID', null),

    'otp_namespace' => env('QICUS_OTP_NAMESPACE', null),
    'otp_template_name' => env('QICUS_OTP_TEMPLATE_NAME', null),

    'utils_accepted_namespace' => env('QICUS_UTILS_ACCEPTED_NAMESPACE', null),
    'utils_accepted_template_name' => env('QICUS_UTILS_ACCEPTED_TEMPLATE_NAME', null),

    'utils_rejected_namespace' => env('QICUS_UTILS_REJECTED_NAMESPACE', null),
    'utils_rejected_template_name' => env('QICUS_UTILS_REJECTED_TEMPLATE_NAME', null),
];
