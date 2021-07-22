<?php


namespace App\Services\Tistory\EndPoint\Oauth\Resource;


use Illuminate\Support\Facades\Http;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractSubClient;

class Authorize extends AbstractSubClient
{
    public function __construct(string $host = null)
    {
        if (is_null($host)) {
            $host = config('tistory.host');
        }
        parent::__construct($host);
    }

    /**
     * @param string $clientId
     * @param string $redirectUri
     * @param string $responseType
     * @param string $state
     * @return array|mixed|string|null
     */
    public function request(string $clientId, string $redirectUri, string $responseType, string $state)
    {
        return $this->response(Http::get($this->url, [
            'client_id' => $clientId, 'redirect_uri' => $redirectUri, 'response_type' => $responseType, 'state' => $state
        ]));
    }
}
