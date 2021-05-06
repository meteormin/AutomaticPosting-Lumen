<?php

namespace App\DataTransferObjects\Utils;

use TypeError;
use JsonMapper;
use Illuminate\Contracts\Support\Jsonable;
use App\DataTransferObjects\Utils\Property;
use Illuminate\Contracts\Support\Arrayable;
use App\DataTransferObjects\Utils\ArrController;

trait Transformation
{
    /**
     * 배열로 변환
     * $allowNull 파라미터가 true면 null인 필드도 배열로 리턴
     * @param boolean $allowNull
     * @return array|null
     */
    public function toArray(bool $allowNull = false): ?array
    {
        $property = new Property($this);

        $attributes = ArrController::snakeFromArray($property->toArray());

        if (!$allowNull) {
            $attributes = ArrController::exceptNull($attributes);
        }

        $attributes = collect($attributes)->map(function ($item) {

            if ($item instanceof Arrayable) {
                return $item->toArray();
            }

            return $item;
        });

        return $attributes->isEmpty() ? null : $attributes->all();
    }

    /**
     * toJson
     *
     * @param boolean $allowNull
     * @param int $options
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE, $allowNull = true): string
    {
        return json_encode($this->toArray($allowNull), $options);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * map array or object
     * JsonMapper 라이브러리 사용
     * @param Arrayable|array $data
     * @param bool $clena
     * @return $this
     */
    public function map($arrayAble, bool $clean = false)
    {
        if ($clean) {
            $self = $this->clear();
        } else {
            $self = $this;
        }

        $jsonMapper = new JsonMapper;

        if ($arrayAble instanceof Jsonable) {
            $json = json_decode($arrayAble->toJson());
            if (is_object($json)) {
                $jsonMapper->map($json, $self);
            }
            return $self;
        }

        if ($arrayAble instanceof Arrayable) {
            $json = json_decode(json_encode($arrayAble->toArray()));
            if (is_object($json)) {
                $jsonMapper->map($json, $self);
            }
            return $self;
        }

        if (empty($arrayAble)) {
            return $self;
        }

        if (!is_object($arrayAble) && !is_array($arrayAble)) {
            return $self;
        }

        $json = json_decode(json_encode($arrayAble));
        if (is_object($json)) {
            $jsonMapper->map($json, $self);
        }

        return $self;
    }


    /**
     * map List
     *
     * @param array|Arrayable $data
     *
     * @return Collection
     */
    public function mapList($data)
    {
        if (!$data instanceof Arrayable  && !is_array($data)) {
            throw new TypeError(get_class($data) . '은 현재 Dto에서 매핑할 수 없습니다.');
        }

        $rsList = collect();
        foreach ($data as $value) {
            $entity = $this->newInstance();

            $rsList->add($entity->map($value));
        }

        return collect($rsList);
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public static function newInstance($params = null)
    {
        return new static($params);
    }

    public function clear()
    {
        return $this->newInstance();
    }
}
