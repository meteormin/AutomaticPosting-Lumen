<?php

return [
    'host' => 'https://opendart.fss.or.kr',
    'api_key' => env('OPEN_DART_API_KEY'),
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
    ],
    'report_code' => []
];
