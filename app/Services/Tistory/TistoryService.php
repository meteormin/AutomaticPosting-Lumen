<?php


namespace App\Services\Tistory;

use App\Models\Posts;
use App\Data\DataTransferObjects\Posts as Dto;
use App\Data\DataTransferObjects\TistoryPost;
use App\Services\AutoPostInterface;
use App\Services\AutoPostService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use JsonMapper_Exception;

class TistoryService extends AutoPostService implements AutoPostInterface
{
    /**
     * @var TistoryClient
     */
    protected TistoryClient $client;

    /**
     * TistoryService constructor.
     */
    public function __construct()
    {
        $this->client = TistoryClient::newInstance();
    }


    /**
     * @param string $type
     * @param int|null $postId
     * @return array|string|null
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function autoPost(string $type, int $postId = null)
    {
        $posts = Posts::getForAutoPost($type, $postId);

        $dto = Dto::newInstance($posts);
        $this->makePublicImg($dto);

        $postClient = $this->client->apis()->post();
        $content = Storage::disk('local')->get($dto->getContentImgPath());
        $img = $postClient->attach('post_' . $dto->getId(), $content);
        $imgUrl = $img['url'];

        $content = "<h3>{$dto->getTitle()}</h3>";
        $content .= "<br>";
        $content .= "<figure><img alt=\"{$dto->getSubTitle()}\" src=\"{$imgUrl}\"><figcaption>{$dto->getSubTitle()}</figcaption></figure>";

        $input = TistoryPost::newInstance([
            'title' => $dto->getTitle(),
            'content' => $content
        ]);

        return $postClient->write($input);
    }
}
