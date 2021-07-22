<?php


namespace App\Services\Tistory;


use App\Services\Tistory\EndPoint\Oauth\Oauth;
use Miniyus\RestfulApiClient\Api\ApiClient;


/**
 * Class TistoryClient
 * @package App\Services\Tistory
 * @method Oauth oauth()
 * @method Apis apis()
 */
class TistoryClient extends ApiClient
{
    /**
     * TistoryClient constructor.
     * @param string|null $host
     * @param string $type
     */
    public function __construct(string $host = null, string $type = 'storage')
    {
        if (is_null($host)) {
            $host = config('tistory.host');
        }

        parent::__construct($host, $type, 'tistory');
    }
}
