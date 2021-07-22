<?php


namespace App\Services\Tistory\EndPoint\Oauth;

use App\Services\Tistory\EndPoint\Oauth\Resource\Access_token;
use App\Services\Tistory\EndPoint\Oauth\Resource\Authorize;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractEndPoint;

/**
 * Class Oauth
 * @package App\Services\Tistory\EndPoint\Oauth
 * @method Authorize authorize()
 * @method Access_token access_token()
 */
class Oauth extends AbstractEndPoint
{
    public function __construct(string $host = null)
    {
        if (is_null($host)) {
            $host = config('tistory.host');
        }
        parent::__construct($host);
    }

    public function endPoint(): string
    {
        return 'oauth';
    }

    /**
     * @return array|mixed|string|null
     */
    public function auth()
    {
        $token = null;
        $clientId = config('tistory.client_id');
        $clientSecret = config('tistory.client_secret');
        $redirectUri = config('tistory.redirect_uri');
        $responseType = config('tistory.response_type');
        $state = 'miniyus';

        $result = $this->authorize()->request($clientId, $redirectUri, $responseType, $state);

        if (isset($result['code'])) {
            $token = $this->access_token()->request($clientId, $clientSecret, $redirectUri, $result['code']);
        }

        if (isset($token)) {
            $this->setToken($token['access_token'], 'storage');
        }

        return $token;
    }
}
