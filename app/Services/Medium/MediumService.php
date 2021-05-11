<?php

namespace App\Services\Medium;

use App\Data\DataTransferObjects\Posts as PostsDto;
use App\Models\Posts;
use App\Services\Service;
use App\Services\AutoPostInterface;
use App\Services\Medium\MediumClient;
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
     */
    public function autoPost(string $type, int $postsId = null): ?array
    {
        if (is_null($postsId)) {
            $posts = Posts::where('type', $type)
                ->where('published', false)
                ->orderByDesc('created_at')
                ->first();
        } else {
            $posts = Posts::find($postsId);
        }

        if(is_null($posts)){
            return null;
        }

//        $posts->published = 1;
//        $posts->save();
        return $this->client->posts(PostsDto::newInstance($posts->toArray()));
    }
}
