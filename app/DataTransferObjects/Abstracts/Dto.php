<?php

namespace App\DataTransferObjects\Abstracts;

use JsonMapper;
use App\Exceptions\DtoErrorException;
use Illuminate\Contracts\Support\Jsonable;
use App\DataTransferObjects\Utils\Property;
use Illuminate\Contracts\Support\Arrayable;
use App\DataTransferObjects\Utils\ArrController;

abstract class Dto implements DtoInterface, Arrayable, Jsonable
{
    /**
     * 출력하지 않을 속성들의 배열
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * 임의 public 속성 추가 방지
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        throw new DtoErrorException("{$key}: 유효하지 않는 속성");
    }

    /**
     * Dto속성 값들을 연관배열로 반환(출력용)
     * 속성의 접근제한자를 proteced(+public)로 지정한 속성만 출력 된다.
     * 속성 값이 null이면 출력되지 않는다. (빈 값의 출력을 원하면 0혹은 공백으로 처리)
     * null값도 출력 하고자 한다면 toArray인자 값에 true를 넣으면 된다.
     *
     * @param   bool $allowNull 널 허용 여부(true:허용/false:불가)
     * @return  array|null   [return description]
     */
    public function toArray(bool $allowNull = true): ?array
    {
        $property = new Property($this);

        $attributes = ArrController::snakeFromArray($property->toArray());

        if (!$allowNull) {
            $attributes = ArrController::exceptNull($attributes);
        }

        $attributes = collect($attributes)->map(function ($item, $key) {
            if ($item instanceof Arrayable) {
                return $item->toArray();
            }

            return $item;
        });

        $attributes = $attributes->except(array_merge(['hidden'], $this->hidden));

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
     * [makeHidden description]
     * toArray() 메서드 작동 시, 숨기고 싶은 속성을 정할 수 있다
     * @param   string|array  $hidden  [$hidden description]
     *
     * @return  $this           [return description]
     */
    public function makeHidden($hidden)
    {
        $this->hidden = collect($this->hidden);

        $this->hidden = $this->hidden->merge($hidden)->all();

        return $this;
    }

    /**
     * [makeVisible description]
     * toArray() 메서드 작동 시, 숨겼던 속성 항목을 다시 출력 시킬 수 있다.
     * @param   string|array  $visible  [$visible description]
     *
     * @return  $this     [return description]
     */
    public function makeVisible($visible)
    {
        $this->hidden = collect($this->hidden);

        $this->hidden = $this->hidden->filter(function ($item) use ($visible) {
            if (is_array($visible)) {
                foreach ($visible as $val) {
                    if ($item != $val) {
                        $cond = true;
                    } else {
                        return false;
                    }
                }
                return $cond;
            }

            return $item != $visible;
        });

        return $this;
    }

    /**
     * clear
     * @deprecated  deprecated since php version 7.4  this method can't use property type
     *
     * @return $this
     */
    public function clear()
    {
        $property = new Property($this);

        foreach ($property->toArrayKeys() as $key) {
            $this->$key = null;
        }

        $this->hidden = [];

        return $this;
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
            throw new DtoErrorException(get_class($data) . '은 현재 Dto에서 매핑할 수 없습니다.');
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
    public function newInstance()
    {
        return new $this;
    }

    /**
     * Get 출력하지 않을 속성들의 배열
     *
     * @return  array
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
