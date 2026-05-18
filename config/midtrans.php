<?php

return [
    /**
     * Midtrans Server Key
     */
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    /**
     * Midtrans Client Key
     */
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    /**
     * Merchant ID
     */
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),

    /**
     * Set true to use Sandbox environment
     * Set false to use Production environment
     */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /**
     * Sanitized true = always sanitize output
     * Sanitized false = never sanitize output
     */
    'sanitized' => env('MIDTRANS_SANITIZED', true),

    /**
     * 3ds true = always use 3DS
     * 3ds false = sometimes use 3DS
     */
    'enable_3ds' => env('MIDTRANS_ENABLE_3DS', false),
];
