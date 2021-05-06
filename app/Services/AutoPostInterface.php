<?php

namespace App\Services;

interface AutoPostInterface
{
    /**
     * auto post
     *
     * @param string $type
     * @return string|int created post id
     */
    public function autoPost(string $type);
}
