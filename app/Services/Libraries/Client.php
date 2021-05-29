<?php

namespace App\Services\Libraries;

use Illuminate\Http\Client\Response;


/**
 * Laravel Http Client wrapper
 */
abstract class Client
{
    /**
     * @var string|null
     */
    protected ?string $host;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var array|string
     */
    protected $error = null;

    /**
     * 생성자
     * 생성하면서 host, token, token type을 설정할 수 있다.
     * host를 설정하지 않을 경우 config폴더의 api파일의 host를 따르게 된다.
     * token은 생성 시 설정 하지 않은 경우 setToken메서드를 이용하면 된다.
     *
     * @param string|null $host [$host description]
     */
    public function __construct(string $host = null)
    {
        $this->host = $host;
    }

    /**
     * @param string|null $host
     * @return Client
     */
    public static function newInstance(string $host = null): Client
    {
        return new static($host);
    }

    /**
     * 요청 결과에 맞게 응답을 준다.
     * error면 error속성에
     * 정상결과면 response속성에 결과를 대입
     * @param Response $response [$response description]
     *
     * @return array|string                   [return description]
     */
    protected function response(Response $response)
    {
        $this->response = $response;

        if ($response->successful()) {
            return $response->json() ?? $response->body();
        } else if ($response->clientError()) {
            $this->error = $response->json() ?? $this->response->body();
            return $this->error;
        } else {
            return $response->json() ?? $response->body();
        }
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return array|string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the value of host
     * @return string
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * Set the value of host
     * @param string $host
     * @return  $this
     */
    public function setHost(string $host): Client
    {
        $this->host = $host;

        return $this;
    }
}
