<?php

namespace App\Services;

interface AutoPostInterface
{
    /**
     * auto post
     *
     * @param string $type
     * @param integer $userId
     * @param string $createdBy
     *
     * @return string|int created post id
     */
    public function autoPost(string $type, int $userId, string $createdBy);
}
