<?php

namespace App\DataTransferObjects\Abstracts;

use Illuminate\Contracts\Support\Arrayable;

interface DtoInterface
{
    public function __set($key, $value);

    public function toArray(bool $allowNull = true): ?array;

    public function toJson($options = JSON_UNESCAPED_UNICODE, $allowNull = true): string;

    public function __toString(): string;

    /**
     * Undocumented function
     *
     * @param string|array $hidden
     *
     * @return $this
     */
    public function makeHidden($hidden);

    public function makeVisible($visible);

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function clear();

    /**
     *
     *
     * @param array|Arrayable|object $data
     *
     * @return $this
     */
    public function map($data);

    /**
     * Undocumented function
     *
     * @param array|Arrayable $data
     *
     * @return Collection
     */
    public function mapList($data);

    /**
     * Undocumented function
     *
     * @return $this
     */
    public static function newInstance($params = null);
}
