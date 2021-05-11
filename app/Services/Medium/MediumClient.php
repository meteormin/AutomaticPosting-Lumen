<?php

namespace App\Services\Medium;

use App\Data\DataTransferObjects\MediumPosts;
use App\Data\DataTransferObjects\Posts;
use App\Services\Libraries\Client;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MediumClient
{
    /**
     * Undocumented variable
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected array $config;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected array $methods;

    /**
     * Undocumented function
     *
     * @param string|null $key
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
     * @param string|null $key
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

    public function client(): Client
    {
        return $this->client;
    }

    /**
     * MediumClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->config = config('medium');

        $this->methods = $this->config('methods');
        $this->client = $client->setHost($this->config('host'));
        $this->client->setToken($this->config('token'));
    }

    /**
     * @return void
     */
    public function resetClient(){
        $this->client = new Client($this->config('host'));
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
        $mediumPosts->setContent($posts->getContents());
        $mediumPosts->setTags([
            '주식',
            $posts->getType('ko'),
            $posts->getCode('ko')
        ]);

        $response = $this->client->post($this->methods('posts.end_point'), $mediumPosts->toArray());

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $response;
    }

    /**
     * @param string $contents
     * @return array|string
     */
    public function images(string $contents)
    {
        $response = $this->client
            ->setAttach('image', $contents, 'posts_' . Carbon::now()->timestamp . '.png')
            ->post($this->methods('images.end_point'));

        if (is_null($response)) {
            return $this->client->getError();
        }

        return $response;
    }
}
