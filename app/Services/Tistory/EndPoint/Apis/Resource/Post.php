<?php


namespace App\Services\Tistory\EndPoint\Apis\Resource;


use App\Data\DataTransferObjects\TistoryPost;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Http;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractSubClient;

class Post extends AbstractSubClient
{
    /**
     * @param int $page
     * @param string|null $blogName
     * @return array|string|null
     * @throws FileNotFoundException
     */
    public function list(int $page = 1, string $blogName = '')
    {
        $this->url .= '/list';
        return $this->get([
            'access_token' => $this->getToken(),
            'output' => 'json',
            'blogName' => config('api_server.tistory.end_point.apis.post.list.blogName', $blogName),
            'page' => $page
        ]);
    }

    /**
     * @param int $postId
     * @param string $blogName
     * @return array|string|null
     * @throws FileNotFoundException
     */
    public function read(int $postId, string $blogName = '')
    {
        $this->url .= '/read';
        return $this->get([
            'access_token' => $this->getToken(),
            'blogName' => config('api_server.tistory.end_point.apis.post.list.blogName', $blogName),
            'postId' => $postId
        ]);
    }

    /**
     * @param TistoryPost $post
     * @param string $blogName
     * @return array|string|null
     * @throws FileNotFoundException
     */
    public function write(TistoryPost $post, string $blogName = '')
    {
        $this->url .= '/write';
        return $this->post(array_merge([
            'access_token' => $this->getToken(),
            'output' => 'json',
            'blogName' => config('api_server.tistory.end_point.apis.post.list.blogName', $blogName),
        ], $post->toArray()));
    }

    /**
     * @param string $fileName
     * @param string $fileContent
     * @param string $blogName
     * @return array|mixed|string|null
     * @throws FileNotFoundException
     */
    public function attach(string $fileName, string $fileContent, string $blogName = '')
    {
        $this->url .= '/attach';
        return $this->response(
            Http::attach($fileName, $fileContent)->post($this->url, [
                'access_token' => $this->getToken(),
                'blogName' => config('api_server.tistory.end_point.apis.post.list.blogName', $blogName),
            ])
        );
    }
}
