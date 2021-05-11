<?php

return [
    // OAuth2
    '2' => [
        'description' => '지원하지않는 grant_type',
        'message' => '지원하지 않는 grant_type입니다',
        'http' => '400'
    ],
    '3' => [
        'description' => '필수파라미터 없음',
        'message' => '필수 파라미터가 없습니다',
        'http' => '400'
    ],
    '4' => [
        'description' => '클라이언트인증 실패',
        'message' => '클라이언트 인증 실패',
        'http' => '400'
    ],
    '5' => [
        'description' => '유효하지 않은 SCOPE',
        'message' => '유효하지 않은 SCOPE',
        'http' => '400'
    ],
    '6' => [
        'description' => 'INVALID_CREDENTIALS',
        'message' => 'INVALID_CREDENTIALS',
        'http' => '400'
    ],
    '7' => [
        'descriptoin' => 'OAUTH_SERVER_ERROR',
        'message' => 'OAUTH_SERVER_ERROR',
        'http' => '500'
    ],
    '8' => [
        'description' => '유효하지않는 refresh_token',
        'message' => '유효하지 않은 refresh_token입니다',
        'http' => '401'
    ],
    '9' => [
        'description' => '토큰 인증 실패',
        'message' => '토큰 인증 실패입니다',
        'http' => '401'
    ],
    '10' => [
        'description' => '사용자인증정보 불일치',
        'message' => '사용자 인증 정보가 맞지 않습니다',
        'http' => '400'
    ],

    // API
    '20' => [
        'description' => '존재하지않는 요청',
        'message' => '존재하지 않는 요청',
        'http' => '404'
    ],
    '21' => [
        'description' => '존재하지않는 Method',
        'message' => '존재하지 않는 method',
        'http' => '405'
    ],
    '22' => [
        'description' => 'Authorization헤더에 토근이 없음',
        'message' => '토큰이 없습니다',
        'http' => '400'
    ],
    '23' => [
        'description' => '유효하지 않는 access_token',
        'message' => '유효하지 않는 access_token',
        'http' => '401'
    ],
    '24' => [
        'description' => '유효성검사 실패',
        'message' => '유효성검사 실패',
        'http' => '400'
    ],
    '25' => [
        'description' => '접근권한 없음',
        'message' => '접근 권한이 없습니다',
        'http' => '403'
    ],
    '26' => [
        'description' => '데이터 충돌',
        'message' => '중복 데이터입니다.',
        'http' => '409'
    ],
    '27' => [
        'description' => '존재하지 않는 리소스(데이터)',
        'message' => '해당 리소스가 존재하지 않습니다',
        'http' => '404'
    ],
    '28' => [
        'description' => 'Query Error',
        'message' => 'Query Error',
        'http' => '500'
    ],
    '29' => [
        'description' => '서버점검',
        'message' => '서버점검',
        'http' => '503'
    ],
    '99' => [
        'description' => '서버 오류',
        'message' => '서버 오류, 서버 관리자에게 문의 해주시기 바랍니다',
        'http' => '500'
    ],
];
