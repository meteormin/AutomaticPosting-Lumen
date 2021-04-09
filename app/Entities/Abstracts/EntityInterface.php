<?php

namespace App\Entities\Abstracts;

use Illuminate\Contracts\Support\Arrayable;

interface EntityInterface
{
    /**
     * Undocumented function
     *
     * @param string $key
     * @param string $value
     * @return void
     *
     * @throws \App\Exceptions\EntityErrorException
     */
    public function __set($key, $value);

    /**
     *
     *
     * @param boolean $allowNull
     * @return array
     */
    public function toArray(bool $allowNull = false): ?array;

    /**
     * Undocumented function
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE): string;

    public function __toString(): string;

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function newInstance();

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function clear();

    /**
     * model객체와 mapping
     *
     * @param  Model|array|Arrayable $model
     * @return $this
     */
    public function map($model);

    /**
     * model 리스트와 매핑
     *
     * @param array|\Illuminate\Database\Eloquent\Collection $models
     * @return \App\Libraries\MapperV2\Entity\Entities|\Illuminate\Support\Collection
     */
    public function mapList($models);

    /**
     * to model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function toModel();
}
