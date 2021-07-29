<?php


namespace App\Services\Tistory\EndPoint\Apis;


use Miniyus\RestfulApiClient\Api\EndPoint\AbstractEndPoint;

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
