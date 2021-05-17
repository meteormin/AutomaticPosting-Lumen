<?php

namespace App\Services\Medium;

use App\Data\DataTransferObjects\Posts as PostsDto;
use App\Models\Posts;
use App\Services\Service;
use App\Services\AutoPostInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;

class MediumService extends Service implements AutoPostInterface
{
    protected MediumClient $client;

    public function __construct(MediumClient $client)
    {
        $this->client = $client;
    }

    /**
     * Undocumented function
     *
     * @return MediumClient
     */
    public function client(): MediumClient
    {
        return $this->client;
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param int|null $postsId
     *
     * @return array|null
     * @throws JsonMapper_Exception
     * @throws FileNotFoundException
     */
    public function autoPost(string $type, int $postsId = null): ?array
    {
        $posts = Posts::getForAutoPost($type,$postsId);

        $dto = PostsDto::newInstance($posts);
        if (is_null($dto->getContentImg())) {
            return null;
        }

        $res = $this->client->images($dto->getContentImg());

        if (isset($res['data'])) {
            $url = $res['data']['url'];
            $content = "<h3>{$dto->getTitle()}</h3>";
            $content .= "<br>";
            $content .= "<figure><img alt=\"{$dto->getSubTitle()}\" src=\"{$url}\"><figcaption>{$dto->getSubTitle()}</figcaption></figure>";

            $dto->setContents($content);
        }

        $posts->published = 1;
        $posts->save();

        return $this->client->posts($dto);
    }
}
