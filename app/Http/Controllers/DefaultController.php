<?php

namespace App\Http\Controllers;

use App\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Response\ErrorCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Psy\Util\Json;

class DefaultController extends Controller
{
    /**
     * 생성 혹은 조회
     * @param mixed $response
     * @param int $status
     * @return JsonResponse
     */
    protected function response($response,int $status = 200): JsonResponse
    {
        return ApiResponse::response($response, $status);
    }

    /**
     * 수정 혹은 삭제
     * @param mixed $response
     * @param string $method
     *
     * @return JsonResponse
     */
    protected function success($response,string $method = 'GET'): JsonResponse
    {
        return ApiResponse::success($response, $method);
    }

    /**
     * @param MessageBag $messageBag
     *
     * @return JsonResponse
     */
    protected function validationFail(MessageBag $messageBag): JsonResponse
    {
        return ApiResponse::error(ErrorCode::VALIDATION_FAIL, $messageBag);
    }

    /**
     * @param integer $code
     * @param string|array|null $message
     *
     * @return JsonResponse
     */
    protected function error(int $code, $message): JsonResponse
    {
        return ApiResponse::error($code, $message);
    }
}
