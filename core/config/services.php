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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => '979345517436-attb853dk2m64gpc2rg3s6aqjlt7clmc.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://elvektechnologies.com/teachow/authorized/google/callback',
    ],

    'facebook' => [
        'client_id' => 'your client ID',
        'client_secret' => 'your client secret',
        'redirect' => 'https://elvektechnologies.com/teachow/callback',
    ],

    'linkedin' => [
        'client_id' => 'xxxxxxxxxxx',
        'client_secret' => 'xxxxxxxxxx',
        'redirect' => 'https://elvektechnologies.com/teachow/auth/linkedin/callback',
    ],

];
