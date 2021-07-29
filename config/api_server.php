<?php

return [
    'default' => [
        'host' => env('API_SERVER', 'http://127.0.0.1'),
        'module_namespace' => '\\Miniyus\\RestfulApiClient\\Api\\EndPoint',
        'token_storage' => [
            'storage' => ['name' => 'access_token'],
            'model' => ['name' => null],
            'session' => ['name' => 'access_token'],
            'cookie' => ['name' => 'access_token']
        ],
        'end_point' => []
    ],
    'tistory' => [
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
        'redirect_uri' => 'http://localhost:8080/tistory/callback',
        'response_type' => 'code',
        'state' => '',
        'end_point' => [
            'oauth' => [],
            'apis' => [
                'post' => [
                    'list' => [
                        'blogName' => env('TISTORY_BLOG_NAME')
                    ]
                ]
            ],
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
    ]
];
