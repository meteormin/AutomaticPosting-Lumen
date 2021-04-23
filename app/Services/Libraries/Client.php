<?php

namespace App\Services\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response as HttpResponse;

/**
 * Laravel Http Client wrapper
 */
class Client
{
    private $host;
    private $headers;
    private $options;
    private $token;
    private $token_type;
    private $attachment;
    private $response;
    private $error;
    private $asForm;

    /**
     * 생성자
     * 생성하면서 host, token, token type을 설정할 수 있다.
     * host를 설정하지 않을 경우 config폴더의 api파일의 host를 따르게 된다.
     * token은 생성 시 설정 하지 않은 경우 setToken메서드를 이용하면 된다.
     *
     * @param   string  $host        [$host description]
     * @param   string  $token       [$token description]
     * @param   string  $token_type  [$token_type description]
     *
     */
    public function __construct(string $host = null, string $token = null, string $token_type = 'Bearer')
    {
        $this->host = $host;
        $this->token = $token;
        $this->token_type = $token_type;
        $this->asForm = false;
    }

    /**
     * [makeRequest description]
     * Http-Client를 통해 api로 요청을 보낸다.
     * @param   string  $method      메서드 이름
     * @param   string  $ep          api의 end-point
     * @param   array   $parameters  요청 파라미터
     * @return  string|array              [return description]
     */
    private function makeRequest(string $method = null, string $ep = '', array $parameters = null)
    {
        $client = null;
        $withOptions = $this->getOptions();
        $withToken = $this->getToken();
        $attach = $this->getAttach();
        $withHeaders = $this->getHeaders();

        if (!is_null($withOptions)) {
            if (is_null($client)) {
                $client = Http::withOptions($withOptions);
            } else {
                $client = $client->withOptions($withOptions);
            }
        }

        if (!is_null($withHeaders)) {
            if (is_null($client)) {
                $client = Http::withHeaders($withHeaders);
            } else {
                $client = $client->withToken($withToken, $this->token_type);
            }
        }

        if (!is_null($withToken)) {
            if (is_null($client)) {
                $client = Http::withToken($withToken, $this->token_type);
            } else {
                $client = $client->withToken($withToken, $this->token_type);
            }
        }

        if (!is_null($attach)) {
            if (is_array($attach)) {
                foreach ($attach as $key => $value) {
                    if (is_null($client)) {
                        $client = Http::attach($key, $value);
                    } else {
                        $client->attach($key, $value);
                    }
                }
            }
        }

        if ($this->asForm) {
            if (is_null($client)) {
                $client = Http::asForm();
            } else {
                $client = $client->asForm();
            }
        }

        if (is_null($client)) {
            $response = Http::{$method}($this->host . $ep, $parameters);
        } else {
            $response = $client->{$method}($this->host . $ep, $parameters);
        }

        Log::info("
        [Http Client Connect]\n
        request: " . Str::upper($method) . " {$this->host}{$ep}\n
        input:" . json_encode($parameters, JSON_UNESCAPED_UNICODE) . "\n
        response:" . json_encode($response->json() ?? $response->body(), JSON_UNESCAPED_UNICODE) . "
        ");

        return $this->response($response);
    }

    public function get(string $endPoint, array $parameters = null)
    {
        return $this->makeRequest('get', $endPoint, $parameters);
    }

    public function post(string $endPoint, array $parameters = null)
    {
        return $this->makeRequest('post', $endPoint, $parameters);
    }

    public function put(string $endPoint, array $parameters = null)
    {
        return $this->makeRequest('put', $endPoint, $parameters);
    }

    public function delete(string $endPoint, array $parameters = null)
    {
        return $this->makeRequest('delete', $endPoint, $parameters);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function asForm()
    {
        $this->asForm = true;
        return $this;
    }

    /**
     * 토큰 설정
     * 기본은 bearer토큰이다
     *
     * @param   string|null  $token     [$token description]
     * @param   string  $tokenType   [$authType description]
     *
     * @return  $this             [return description]
     */
    public function setToken(?string $token, string $tokenType = 'Bearer')
    {
        $this->token = $token;
        $this->token_type = $tokenType;
        return $this;
    }

    /**
     * 설정한 토큰 가져오기
     *
     * @return  string [return description]
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 파일 첨부
     *
     * @param   string  $key     [$key description]
     * @param   mixed  $attach  [$attach description]
     *
     * @return  $this           [return description]
     */
    public function setAttach(string $key, $attach)
    {
        $this->attachment[$key] = $attach;

        return $this;
    }

    /**
     * 첨부한 파일 조회
     *
     * @return  mixed  [return description]
     */
    public function getAttach()
    {
        return $this->attachment;
    }

    /**
     * 요청 결과에 맞게 응답을 준다.
     * error면 error속성에
     * 정상결과면 response속성에 결과를 대입
     * @param   HttpResponse  $response  [$response description]
     *
     * @return  mixed                   [return description]
     */
    private function response(HttpResponse $response)
    {
        $this->response = $response;

        if ($response->successful()) {
            return $this->response->json() ?? $this->response->body();
        } else if ($response->clientError()) {
            $this->error = $response->json();

            return $this->error;
        } else {
            return $this->response->json() ?? $this->response->body();
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the value of host
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of host
     * @param string $host
     * @return  $this
     */
    public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the value of options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}
