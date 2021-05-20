<?php

namespace App\Services\WordPress;

use App\Data\DataTransferObjects\WPosts;
use App\Services\Libraries\Client;

class WpClient
{
    /**
     * @var string|array|mixed|null
     */
    protected ?string $host;

    /**
     * MediumClient constructor.
     */
    public function __construct()
    {
        $this->host = config('wordpress.host');
    }

    /**
     * @return Client
     */
    public function client(): Client
    {
        return Client::newInstance($this->host);
    }

    /**
     * @return array|string
     */
    public function auth(){
        $client = $this->client();
        return $client->post('/wp-json/jwt-auth/v1/token',[
            'username'=>config('wordpress.id'),
            'password'=>config('wordpress.pwd')
        ]);
    }

    /**
     * @param WPosts $input
     * @return array|string
     */
    public function posts(WPosts $input)
    {
        $auth = $this->auth();
        $client = $this->client();
        $response = $client->setToken($auth['token'])->post('/wp-json/wp/v2/posts',$input->toArray());

        if (is_null($response)) {
            return $this->client()->getError();
        }

        return $response;
    }
}
