<?php

namespace App\Services\Medium;

use App\Models\Posts;
use App\Services\Service;
use App\Services\AutoPostInterface;
use App\Services\Medium\MediumClient;

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
    public function client()
    {
        return $this->client;
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param integer $postsId
     *
     * @return array
     */
    public function autoPost(string $type, int $postsId = null)
    {
        if (is_null($postsId)) {
            $posts = Posts::where('type', $type)
                ->where('published', false)
                ->orderByDese('created_at')
                ->first();
        } else {
            $posts = Posts::find($postsId);
        }

        return $this->client->posts($posts);
    }
}
