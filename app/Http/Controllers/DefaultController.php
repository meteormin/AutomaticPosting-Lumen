<?php

namespace App\Http\Controllers;

use App\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Response\ErrorCode;

class DefaultController extends Controller
{
    use ErrorCode;

    /**
     * 생성 혹은 조회
     * @param mixed $response
     * @param int|null $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($response, $status = 200)
    {
        return ApiResponse::response($response, $status);
    }

    /**
     * 수정 혹은 삭제
     * @param mixed $response
     * @param string $method
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($response, $method = 'GET')
    {
        return ApiResponse::success($response, $method);
    }

    /**
     * @param \Illuminate\Support\MessageBag $messageBag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationFail(\Illuminate\Support\MessageBag $messageBag)
    {
        return ApiResponse::error(self::VALIDATION_FAIL, $messageBag);
    }


    /**
     * @param integer $code
     * @param string|array|null $message
     *
     * @return void
     */
    protected function error(int $code, $message)
    {
        return ApiResponse::error($code, $message);
    }
}
