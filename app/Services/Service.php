<?php

namespace App\Services;

use App\Exceptions\ApiErrorException;
use App\Response\ErrorCode;

/**
 * service 클래스
 *
 * 비즈니스 로직
 */
class Service extends ErrorCode
{
    /**
     * @var int $code 에러 코드
     */
    protected $code;

    /**
     * @var string|array|null $error 간단한 에러 메시지
     */
    protected $error;

    /**
     * ApiErrorException Throw
     * ApiResponse::error()로 JSON응답 에러를 던진다.
     *
     * @param integer $code
     * @param string|array|null $message
     *
     * @throws ApiErrorException
     */
    public function throw(int $code = self::SERVER_ERROR, $message = null)
    {
        throw new ApiErrorException($code, $message);
    }

    /**
     * @param integer $code
     * @param string|array|null $message
     *
     * @return null
     */
    public function setError(int $code = self::SERVER_ERROR, $message = null)
    {
        $this->code = $code;
        $this->error = $message;

        return $this;
    }

    /**
     * @return string|array|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return integer
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
