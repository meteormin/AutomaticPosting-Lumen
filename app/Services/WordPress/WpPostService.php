<?php


namespace App\Services\WordPress;


use App\Data\DataTransferObjects\WpMedia;
use App\Data\DataTransferObjects\WPosts;
use App\Models\Posts;
use App\Data\DataTransferObjects\Posts as Dto;
use App\Services\AutoPostInterface;
use App\Services\Service;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;

class WpPostService extends Service implements AutoPostInterface
{
    protected WpClient $client;

    public function __construct(WpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $type
     * @param int|null $postsId
     * @return array|string
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function autoPost(string $type, int $postsId = null)
    {
        $posts = Posts::getForAutoPost($type, $postsId);
        $dto = Dto::newInstance($posts);
        $publicImgFile = "img/posts/{$dto->getId()}.png";

        if (!file_exists(base_path('public/img/posts'))) {
            mkdir(base_path('public/img/posts'));
        }

        if (file_put_contents(base_path('public/' . $publicImgFile), $dto->getContentImg()) === false) {
            $this->throw(self::SERVER_ERROR, 'fail put file...');
        }
        $host = config('app.static_ip') . ':' . config('app.app_port');

        $url = "http://{$host}/{$publicImgFile}";

        $media = WpMedia::newInstance([
            'title' => $dto->getTitle(),
            'content' => $dto->getContentImgPath(),
        ]);

        $mediaResponse = $this->client->uploadMedia($media);
        print_r($mediaResponse);
        $url = $mediaResponse['guid']['rendered'];
        $content = "<h3>{$dto->getTitle()}</h3>";
        $content .= "<br>";
        $content .= "<figure><img alt=\"{$dto->getSubTitle()}\" src=\"{$url}\"><figcaption>{$dto->getSubTitle()}</figcaption></figure>";

        $input = WPosts::newInstance([
            'title' => $dto->getTitle(),
            'content' => $content
        ]);
        return $this->client->posts($input);
    }
}
