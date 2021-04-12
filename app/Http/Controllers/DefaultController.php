<?php

namespace App\Http\Controllers;

use App\Response\ApiResponse;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{

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
     * @param \Illuminate\Support\MessageBag $messageBag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationFail(\Illuminate\Support\MessageBag $messageBag)
    {
        return ApiResponse::error(24, $messageBag);
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
