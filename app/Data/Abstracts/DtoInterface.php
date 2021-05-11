<?php

namespace App\Data\Abstracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface DtoInterface
{
    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function __set($key, $value);

    /**
     * @param bool $allowNull
     * @return array|null
     */
    public function toArray(bool $allowNull = true): ?array;

    /**
     * @param int $options
     * @param bool $allowNull
     * @return string
     */
    public function toJson(int $options = JSON_UNESCAPED_UNICODE, bool $allowNull = true): string;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @param $hidden
     * @return DtoInterface
     */
    public function makeHidden($hidden): DtoInterface;

    /**
     * @param $visible
     * @return DtoInterface
     */
    public function makeVisible($visible): DtoInterface;

    /**
     * @param array|Arrayable $data
     * @return DtoInterface
     */
    public function map($data): DtoInterface;

    /**
     * @param $data
     * @return Collection
     */
    public function mapList($data): Collection;

    /**
     * @param null $params
     * @return DtoInterface
     */
    public static function newInstance($params = null): DtoInterface;
}
