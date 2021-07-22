<?php


namespace App\Services\Tistory\EndPoint\Oauth\Resource;


use Illuminate\Support\Facades\Http;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractSubClient;

class Access_token extends AbstractSubClient
{
    /**
     * AccessToken constructor.
     * @param string|null $host
     */
    public function __construct(string $host = null)
    {
        if (is_null($host)) {
            $host = config('tistory.host');
        }

        parent::__construct($host);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     * @param string $code
     * @param string $grantType
     * @return array|mixed|string|null
     */
    public function request(string $clientId, string $clientSecret, string $redirectUri, string $code, string $grantType = 'authorization_code')
    {
        return $this->response(
            Http::get($this->getHost(), [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'code' => $code,
                'grant_type' => $grantType
            ])
        );
    }
}
