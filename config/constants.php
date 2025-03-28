<?php

//Sandbox
defined('BUSINESS_EMAIL_SANDBOX') || define('BUSINESS_EMAIL_SANDBOX', 'sb-uefcv23946367@business.example.com');

//Live
// defined('PAYPAL_LIVE_BUSINESS_EMAIL') or define('PAYPAL_LIVE_BUSINESS_EMAIL', '');
// defined('PAYPAL_CURRENCY') or define('PAYPAL_CURRENCY', 'USD');

return [
    'UPDATE_PATH' => 'update/',
    'RESPONSE_CODE'    => [
        'LOGIN_SUCCESS'    => 100,
        'VALIDATION_ERROR' => 102,
        'EXCEPTION_ERROR'  => 103,
        'SUCCESS'          => 200,
    ],
    'CACHE'            => [
        'LANGUAGE' => 'languages',
        'SETTINGS' => 'settings'
    ],
    'DEFAULT_SETTINGS' => [
        ['name' => 'currency_symbol', 'value' => '$', 'type' => 'string'],
        ['name' => 'ios_version', 'value' => '1.0.0', 'type' => 'string'],
        ['name' => 'default_language', 'value' => 'en', 'type' => 'string'],
        ['name' => 'force_update', 'value' => '0', 'type' => 'string'],
        ['name' => 'android_version', 'value' => '1.0.0', 'type' => 'string'],
        ['name' => 'number_with_suffix', 'value' => '0', 'type' => 'string'],
        ['name' => 'maintenance_mode', 'value' => 0, 'type' => 'string'],
        ['name' => 'privacy_policy', 'value' => '', 'type' => 'string'],
        ['name' => 'terms_conditions', 'value' => '', 'type' => 'string'],
        ['name' => 'about_us', 'value' => '', 'type' => 'string'],
        ['name' => 'company_tel1', 'value' => '', 'type' => 'string'],
        ['name' => 'system_version', 'value' => env('APP_VERSION'), 'type' => 'string'],
        ['name' => 'company_email', 'value' => '', 'type' => 'string'],
        ['name' => 'company_name', 'value' => 'News App', 'type' => 'string'],


        ['name' => 'app_store_link', 'value' => '', 'type' => 'string'],
        ['name' => 'play_store_link', 'value' => '', 'type' => 'string'],

        ['name' => 'web_theme_color', 'value' => '#00B2CA', 'type' => 'string'],
        ['name' => 'firebase_project_id', 'value' => '', 'type' => 'string'],
        ['name' => 'company_address', 'value' => '', 'type' => 'string']
    ]
];
