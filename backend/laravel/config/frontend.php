<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Front URL
    |--------------------------------------------------------------------------
    |
    | This URL Front is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_FRONT_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Email verification URL
    |--------------------------------------------------------------------------
    |
    | This URL Front for email verification 
    |
    */

    'email_verify_url' => env('APP_FRONT_URL_EMAIL_VERIFY', '/verify-email?query-url='),


];