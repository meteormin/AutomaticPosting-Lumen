<?php

return [
    'host' => 'https://opendart.fss.or.kr',
    'api_key' => env('open_dart_api_key'),
    'method' => [
        'corpCode' => [
            'url' => '/api/corpCode.xml',
            'method' => 'get',
            'type' => 'zip'
        ],
        'MultiAcnt' => [
            'url' => '/api/fnlttMultiAcnt.json',
            'method' => 'get',
            'type' => 'json'
        ],
        'SinglAcnt' => [
            'url' => '/api/fnlttSinglAcnt.json',
            'method' => 'get',
            'type' => 'json'
        ]
    ]
];
