<?php


namespace App\Services\Tistory\EndPoint\Oauth\Resource;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractSubClient;

class AccessToken extends AbstractSubClient
{
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
        Log::info('request access_token');
        Log::info($this->url . '?' . Arr::query([
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'code' => $code,
                'grant_type' => $grantType
            ]));
        return $this->response(
            Http::get($this->url, [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'code' => $code,
                'grant_type' => $grantType
            ])
        );
    }
}
