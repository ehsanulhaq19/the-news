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

    'articles_sources' => [
        'news_org_end_point' => env('NEWS_ORG_END_POINT'),
        'news_org_api_key' => env('NEWS_ORG_API_KEY'),
        
        'the_guardian_end_point' => env('THE_GUARDIAN_END_POINT'),
        'the_guardian_api_key' => env('THE_GUARDIAN_API_KEY'),
        
        'new_york_times_end_point' => env('NEW_YORK_TIMES_END_POINT'),
        'new_york_times_api_key' => env('NEW_YORK_TIMES_API_KEY'),
        'new_york_times_host_url' => env('NEW_YORK_TIMES_HOST_URL'),
    ]

];
