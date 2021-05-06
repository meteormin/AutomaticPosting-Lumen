<?php

namespace App\Services\Medium;

use App\DataTransferObjects\MediumPosts;
use App\DataTransferObjects\Posts;
use App\Services\Libraries\Client;
use Illuminate\Support\Arr;
use App\Exceptions\ApiErrorException;

class MediumClient
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
     * @var array
     */
    protected $config;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $methods;

    /**
     * Undocumented function
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function config(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function methods(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->methods;
        }

        return Arr::get($this->methods, $key, $default);
    }

    public function __construct(Client $client)
    {
        $this->config = config('medium');

        $this->methods = $this->config('methods');
        $this->client = $client->setHost($this->config('host'));
        $this->client->setToken($this->config('token'));
    }

    public function me()
    {
        $response = $this->client->get($this->methods('me.end_point'));

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param Posts $posts
     *
     * @return string|array
     */
    public function posts(Posts $posts)
    {
        $mediumPosts = new MediumPosts;
        $mediumPosts->setTitle($posts->getTitle());
        $mediumPosts->setContents($posts->getContents());
        $mediumPosts->setTags([
            '주식',
            $posts->getType('ko'),
            $posts->getCode('ko')
        ]);

        print_r($mediumPosts->toArray());
        exit;

        $response = $this->client->post($this->methods('posts.end_point'), $mediumPosts->toArray());

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $response;
    }
}
