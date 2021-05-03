<?php

namespace App\Services\Libraries\OAuth;

use App\DataTransferObjects\OAuthRequest;
use App\Services\Libraries\Client;

abstract class OAuthClient
{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    protected $client;

    /**
     * OAuth request
     *
     * @var OAuthRequest
     */
    protected $request;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Undocumented function
     *
     * @param array $inputs
     *
     * @return OAuthRequest
     */
    public function makeRequest(array $inputs = null)
    {
        return $this->request = (new OAuthRequest)->map($inputs);
    }

    public function authorize()
    {
        $ep = 'oauth/authorize';
    }
}
