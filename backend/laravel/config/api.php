<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version Api
    |--------------------------------------------------------------------------
    |
    | This option get version api
    |
    */

    'version' => 'v1',

     /*
    |--------------------------------------------------------------------------
    | Verification email link Timeout
    |--------------------------------------------------------------------------
    |
    |  By default, the timeout minutes.
    |
    */
    'verification' => [
        'expire' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Trial Days Application
    |--------------------------------------------------------------------------
    |
    | This option get trial days used application
    |
    */

    'trial_days' => env('STRIPE_TRIAL_DAYS', '1'),
    
    /*
    |--------------------------------------------------------------------------
    | Trial Amount Application
    |--------------------------------------------------------------------------
    |
    | This option get trial amount application
    |
    */

    'amount_trial' => env('STRIPE_AMOUNT_TRIAL', '1'),

    /*
    |--------------------------------------------------------------------------
    | Currency Application
    |--------------------------------------------------------------------------
    |
    | This option get symbol currency application
    |
    */

    'currency' => env('APP_CURRENCY', 'euro'),
];