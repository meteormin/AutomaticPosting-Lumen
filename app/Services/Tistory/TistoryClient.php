<?php

namespace App\Services\Tistory;

use App\Services\Libraries\Client;
use App\Exceptions\ApiErrorException;
use Illuminate\Support\Facades\Storage;

class TistoryClient
{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    protected $client;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $clientId;

    /**
     * disk
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * path
     *
     * @var string
     */
    protected $path;

    public function __construct(Client $client)
    {
        $this->client = $client->setHost(config('tistory.host'));
        $this->clientId = config('tistory.client_id');
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function authorize()
    {
        $response = $this->client->get(config('tistory.method.authorize.url'), [
            'client_id' => $this->clientId,
            'redirect_uri' => config('tistory.redirect_uri'),
            'response_type' => config('tistory.response_type'),
            'state' => config('tistory.state')
        ]);

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $response;
    }

    /**
     * callback
     *
     * @param string $code
     * @param string|null $state
     * @param string|null $error
     * @param string|null $error_reason
     *
     * @return string|null
     */
    public function callback(string $code, string $state = null, string $error = null, string $error_reason = null)
    {
        if (!is_null($error)) {
            throw new ApiErrorException($error, $error_reason);
        }

        if (!is_null($code)) {
            $accessToken = $this->accessToken($code);
            Storage::disk('local')->put('tistory/token.json', json_encode(['token' => $accessToken]));
            return $accessToken;
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @param string $code
     *
     * @return string|null
     */
    public function accessToken(string $code)
    {
        $response = $this->client->get(config('tistory.method.authorize.url'), [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => config('tistory.client_secret'),
            'code' => $code,
            'redirect_uri' => config('tistory.redirect_uri')
        ]);

        if (isset($response['access_token'])) {
            return $response['access_token'];
        } else if (is_null($response)) {
            $response = $this->client->getResponse()->body();
            return explode('=', $response)[1];
        }

        return $this->client->getError();
    }
}
