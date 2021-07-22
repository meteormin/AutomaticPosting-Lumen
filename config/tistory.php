<?php

return [
    'host' => 'https://www.tistory.com',
    'module_namespace' => '\\App\\Services\\Tistory\\EndPoint',
    'token_storage' => [
        'storage' => ['name' => 'access_token'],
        'model' => ['name' => null],
        'session' => ['name' => 'access_token'],
        'cookie' => ['name' => 'access_token']
    ],
    'client_id' => env('TISTORY_APP_ID'),
    'client_secret' => env('TISTORY_API_KEY'),
    'redirect_uri' => 'http://34.72.111.228/tistory/callback',
    'response_type' => 'code',
    'state' => '',
    'end_point'=>[
        'oauth'=>[],
        'apis'=>[],
    ],
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
