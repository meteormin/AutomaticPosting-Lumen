<?php

namespace App\Response;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * ApiResponse에서 사용하는 에러 객체
 *
 * 에러 코드
 * 2 ~ 10 oauth2.0 관련 에러
 * 2: 지원하지 않는 grant_type
 * 3: 필수파라미터 없음
 * 4: 클라이언트 인증 실패
 * 5: unknown
 * 6: 사용자 계정 없음(not use)
 * 7: unknown
 * 8: 유효하지 않는 refrech_token
 * 9: 토큰 인증 실패(access_token)
 * 10: 사용자인증정보 불일치
 *
 * API 에러
 * 20: 존재하지 않는 요청
 * 21: 존재하지 않는 method
 * 22: Untoken
 * 23: 유효하지 않는 access_token
 * 24: 유효성검사 실패
 * 25: 접근권한 없음
 * 26: 데이터 충돌, 중복 데이터 혹은 update, delete 실패
 * 27: 존재하지 않는 리소스(데이터)
 * 28: Query Error
 * 29: 서버 점검(503)
 * 99: 500에러, 서버오류
 */
class ErrorResponse extends ErrorCode implements Arrayable, Jsonable
{

    /**
     * @var string $status 상태(error 고정)
     */
    protected const status = 'error';

    /**
     * @var int $code 에러 코드
     */
    protected $code;

    /**
     * @var string $error 에러 유형
     */
    protected $error;

    /**
     * @var string $message 응답에 출력할 에러 메시지
     */
    protected $message;

    /**
     * @var string $request 요청 url정보
     */
    protected $request;

    /**
     * @var string $ip 요청 ip
     */
    protected $ip;

    /**
     * @var string $auth 요청 로그인 정보
     */
    protected $auth;

    /**
     * @var \Illuminate\Support\Collection $errorSet 지정해놓은 에러 메시지 배열 config/error.php 파일에서 설정
     */
    protected $errorSet;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $errorTypes;

    /**
     * error 유형 및 메시지 배열 가젿오기
     *
     * @return  [type]  [return description]
     */
    public function __construct()
    {
        $this->errorTypes = collect(config('error'));
        $this->errorSet = collect(__('error'));
        $this->setIp(Request::ip());
        $this->setRequest(Request::fullUrl());
        $this->setAuth(Auth::user()->id ?? 'unauthorize');
    }

    /**
     * get all errors
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->errorTypes->map(function ($item) {
            return (new $this)->setCode($item);
        });
    }

    /**
     * http status 가져오기
     *
     * @return  [type]  [return description]
     */
    public function getHttpStatus()
    {
        return $this->errorSet[$this->code]['http'];
    }

    /**
     * 배열로 변환
     *
     * @param   string  $responseType  log 저장용 & 에러 출력용
     *
     * @return  array                 [return description]
     */
    public function toArray(string $responseType = '')
    {
        if (Str::lower($responseType) === 'log') {
            return [
                'status' => self::status,
                'code' => $this->code,
                'error' => $this->error,
                'message' => $this->message,
                'request' => $this->request,
                'auth' => $this->auth
            ];
        } else {
            if ($this->code == self::VALIDATION_FAIL) {
                return [
                    'status' => self::status,
                    'code' => $this->code,
                    'error' => $this->error,
                    'messages' => $this->message
                ];
            } else {
                return [
                    'status' => self::status,
                    'code' => $this->code,
                    'error' => $this->error,
                    'message' => $this->message
                ];
            }
        }
    }

    /**
     * Undocumented function
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;
        $this->setError($code);

        return $this;
    }

    /**
     * Get the value of error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @return  self
     */
    public function setError($code)
    {
        if (!$this->errorTypes->contains($code)) {
            return $this;
        }

        $this->error = $this->errorTypes->search($code);

        if (is_null($this->message)) {
            $this->setMessage($this->errorSet[$code]['message']);
        }

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        if (empty($message)) {
            return $this;
        }

        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the value of request
     *
     * @return  self
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the value of auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set the value of auth
     *
     * @return  self
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Get the value of ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip
     *
     * @return  self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }
}
