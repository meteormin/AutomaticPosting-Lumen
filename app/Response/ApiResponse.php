<?php

namespace App\Response;

use Illuminate\Support\Facades\Log;

class ApiResponse
{
    /**
     * [response description]
     * 결과로 데이터를 응답해야 하는 경우에 사용
     * @param  mixed  $data   [description] 데이터객체 혹은 배열
     * @param  integer $status [description] http응답코드, 기본 값은 200이다.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response($data, $status = 200)
    {
        $response = response()->json($data, $status, [], JSON_UNESCAPED_UNICODE);

        return $response;
    }

    /**
     * [success description]
     * query update수행 시, 성공여부를 응답하는 경우에 사용
     * @param  mixed $message [description] 출력할 내용
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, $method = 'GET')
    {
        $method = strtoupper($method);
        $http_status = config('http_status');
        foreach ($http_status as $key => $value) {
            if ($method == $key) {
                $response_code = $value;
            }
        }
        if ($response_code == 204) {
            $data = '';
        }

        $response = response()->json(['message' => $data], $response_code, [], JSON_UNESCAPED_UNICODE);

        return $response;
    }

    /**
     * [error description]
     * error발생 시 사용
     * @param  int $code    [description] 에러 코드
     * @param  string|array|null $message [description] 에러 내용
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(int $code, $message = null)
    {
        $response = new ErrorResponse;

        $response->setCode($code);
        $response->setMessage($message);

        Log::error($response->toArray('LOG'));

        return response()->json($response->toArray(), $response->getHttpStatus(), [], JSON_UNESCAPED_UNICODE);
    }
}
