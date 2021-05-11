<?php

return [
    // OAuth2.0 관련임, 정리 용도
    'UNSUPPORTED_GRANT_TYPE' => 2,
    'INVALID_REQUEST' => 3,
    'INVALID_CLIENT' => 4,
    'INVALID_SCOPE' => 5,
    'INVALID_CREDENTIALS' => 6,
    'OAUTH_SERVER_ERROR' => 7,
    'INVALID_REFRESH_TOKEN' => 8,
    'ACCESS_DENIED' => 9,
    'INVALID_GRANT' => 10,

    // error Throw시 사용

    /**
* 20: 존재하지 않는 요청(404)
*/
    'NOT_FOUND' => 20,

    /**
* 21: 존재하지 않는 메서드(405)
*/
    'ALLOW_NOT_METHOD' => 21,

    /**
* 22: 엑세스 토큰 부재
*/
    'UNTOKEN' => 22,

    /**
* 23: 유효하지 않는 엑세스 토큰
*/
    'UNAUTHORIZED' => 23,

    /**
* 24: 유효성 검사 실패
*/
    'VALIDATION_FAIL' => 24,

    /**
* 25: 접근 권한 없음
*/
    'FORBIDDEN' => 25,

    /**
* 26: 데이터 충돌
*/
    'CONFLICT' => 26,

    /**
* 27: 존재하지 않는 리소스
*/
    'RESOURCE_NOT_FOUND' => 27,

    /**
* 28: 쿼리에러
*/
    'QUERY_ERROR' => 28,

    /**
* 29: 서버 점검 중
*/
    'SERVER_DOWN' => 29,

    /**
* 99: 서버 에러
*/
    'SERVER_ERROR' => 99,
];
