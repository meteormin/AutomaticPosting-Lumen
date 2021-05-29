<?php

namespace App\Services\Medium;

use App\Data\DataTransferObjects\MediumPosts;
use App\Data\DataTransferObjects\Posts;
use App\Services\Libraries\Client;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use JsonMapper_Exception;

class MediumClient extends Client
{
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
     * @var string|array|mixed|null
     */
    protected ?string $host;

    /**
     * @var string|array|mixed|null
     */
    protected ?string $token;

    /**
     * MediumClient constructor.
     */
    public function __construct()
    {
        $this->config = config('medium');
        parent::__construct($this->config('host'));
        $this->methods = $this->config('methods');
        $this->token = $this->config('token');
    }

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

    /**
     * @return array|string
     */
    public function me()
    {
        $response = $this->response(
            Http::get($this->methods('me.end_point'))
        );

        if (is_null($response)) {
            return $this->getError();
        }

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param Posts $posts
     *
     * @return string|array
     * @throws JsonMapper_Exception
     */
    public function posts(Posts $posts)
    {
        $mediumPosts = MediumPosts::newInstance([
            'title' => $posts->getTitle(),
            'content' => $posts->getContents(),
            'tags' => [
                '주식',
                $posts->getType('ko'),
                $posts->getCode('ko')
            ]
        ]);

        $mediumPosts->setTitle($posts->getTitle());
        $mediumPosts->setContent($posts->getContents());
        $mediumPosts->setTags([
            '주식',
            $posts->getType('ko'),
            $posts->getCode('ko')
        ]);

        $response = $this->response(
            Http::post($this->methods('posts.end_point'), $mediumPosts->toArray())
        );

        if (is_null($response)) {
            return $this->getError();
        }

        return $response;
    }

    /**
     * @param string $contents
     * @return array|string
     */
    public function images(string $contents)
    {

        $response = $this->response(
            Http::attach('image', $contents, 'posts_' . Carbon::now()->timestamp . '.png')
                ->post($this->methods('images.end_point'))
        );

        if (is_null($response)) {
            return $this->getError();
        }

        return $response;
    }
}
