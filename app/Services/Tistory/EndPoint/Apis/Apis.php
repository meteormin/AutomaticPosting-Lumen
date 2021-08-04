<?php


namespace App\Services\Tistory\EndPoint\Apis;


use App\Services\Tistory\EndPoint\Apis\Resource\Post;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractEndPoint;

/**
 * Class Apis
 * @package App\Services\Tistory\EndPoint\Apis
 * @author Yoo Seongmin <miniyu97@iokcom.com>
 * @method Post post()
 */
class Apis extends AbstractEndPoint
{
    /**
     * @inheritDoc
     */
    public function endPoint(): string
    {
        return 'apis';
    }
}
