<?php


namespace App\Services\Tistory\EndPoint\Oauth;

use App\Services\Tistory\EndPoint\Oauth\Resource\AccessToken;
use App\Services\Tistory\EndPoint\Oauth\Resource\Authorize;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Log;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractEndPoint;

/**
 * Class Oauth
 * @package App\Services\Tistory\EndPoint\Oauth
 * @method Authorize authorize()
 * @method AccessToken access_token()
 */
class Oauth extends AbstractEndPoint
{
    public function endPoint(): string
    {
        return 'oauth';
    }

    /**
     * @return array|null
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function auth(): ?array
    {
        $loginModule = $this->authorize();

        $res = $loginModule->request(
            config('api_server.tistory.client_id'),
            config('api_server.tistory.redirect_uri'),
            config('api_server.tistory.response_type'),
            config('api_server.tistory.state')
        );

        if (isset($res['code'])) {
            Log::info($res['code']);
            $token = $this->access_token()->request(
                config('api_server.tistory.client_id'),
                config('api_server.tistory.client_secret'),
                config('api_server.tistory.redirect_uri'),
                $res['code']
            );
        } else {
            Log::warning('fail issue token');
            return null;
        }

        [$name, $token] = explode('=', $token);
        Log::info($name . ': ' . $token);
        return [$name => $token];
    }

//    public function auth()
//    {
//        $token = null;
//        $clientId = config('tistory.client_id');
//        $clientSecret = config('tistory.client_secret');
//        $redirectUri = config('tistory.redirect_uri');
//        $responseType = config('tistory.response_type');
//        $state = 'miniyus';
//
//        $result = $this->authorize()->request($clientId, $redirectUri, $responseType, $state);
//
//        if (isset($result['code'])) {
//            $token = $this->access_token()->request($clientId, $clientSecret, $redirectUri, $result['code']);
//        }
//
//        if (isset($token)) {
//            $this->setToken($token['access_token'], 'storage');
//        }
//
//        return $token;
//    }


}
