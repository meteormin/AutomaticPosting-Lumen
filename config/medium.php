<?php

return [
    'host' => 'https://api.medium.com',
    'token' => env('MEDIUM_TOKEN'),
    'methods' => [
        'me' => [
            'method' => 'get',
            'end_point' => '/v1/me/'
        ],
        'pulibcations' => [
            'method' => 'get',
            'end_point' => '/v1/users/{id}/publications'
        ],
        'posts' => [
            'method' => 'post',
            'end_point' => "/v1/users/".env('MEDIUM_AUTHOR_ID')."/posts"
        ],
        'images'=>[
            'method'=>'post',
            'end_point'=>"/v1/images"
        ]
    ]
];
