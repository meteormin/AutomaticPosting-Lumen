<?php


namespace App\Services\Tistory;


use App\Services\Tistory\EndPoint\Apis\Apis;
use App\Services\Tistory\EndPoint\Oauth\Oauth;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Miniyus\RestfulApiClient\Api\ApiClient;


/**
 * Class TistoryClient
 * @package App\Services\Tistory
 * @method static Oauth oauth()
 * @method static Apis apis()
 */
class TistoryClient extends ApiClient
{
    /**
     * TistoryClient constructor.
     * @param string|null $host
     * @param string|null $type
     * @param string $server
     */
    public function __construct(string $host = null, ?string $type = 'storage', string $server = 'tistory')
    {
        parent::__construct($host, $type, $server);
    }

    /**
     * @return static
     * @throws FileNotFoundException
     */
    public static function login(): TistoryClient
    {
        $instance = self::newInstance();
        $token = $instance->oauth()->auth();
        return $instance->setToken($token['access_token'], $instance->type);
    }
}
