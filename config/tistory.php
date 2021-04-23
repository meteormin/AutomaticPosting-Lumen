<?php

return [
    'host' => 'https://www.tistory.com',
    'client_id' => env('TISTORY_APP_ID'),
    'client_secret' => env('TISTORY_API_KEY'),
    'redirect_uri' => null,
    'response_type' => 'code',
    'state' => '',
    'method' => [
        'authorize' => [
            'url' => '/oauth/authorize',
            'method' => 'get',
            'type' => 'json'
        ],
        'accessToken' => [
            'url' => '/oauth/access_token',
            'method' => 'get',
            'type' => 'json'
        ]
    ]
];
