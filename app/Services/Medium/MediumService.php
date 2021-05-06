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
     * @param string $type
     * @param integer $userId
     * @param string $createdBy
     *
     * @return string
     */
    public function autoPost(string $type, int $userId, string $createdBy)
    {
        $posts = Posts::where('type', $type)
            ->where('published', false)
            ->orderByDese('created_at')
            ->first();

        $this->client->posts($posts);
    }
}
