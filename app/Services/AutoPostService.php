<?php

namespace App\Services;

use App\Models\Posts;
use App\Data\DataTransferObjects\Posts as Dto;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class AutoPostService extends Service
{
    /**
     * make public img and return public img url
     * @param Dto $dto
     * @return string
     * @throws FileNotFoundException
     */
    protected function makePublicImg(Dto $dto): string
    {
        $publicImgFile = "img/posts/{$dto->getId()}.png";

        if (!file_exists(base_path('public/img/posts'))) {
            mkdir(base_path('public/img/posts'));
        }

        if (file_put_contents(base_path('public/' . $publicImgFile), $dto->getContentImg()) === false) {
            $this->throw(self::SERVER_ERROR, 'fail put file...');
        }
        $host = config('app.static_ip') . ':' . config('app.app_port');

        return "http://{$host}/{$publicImgFile}";
    }
}
