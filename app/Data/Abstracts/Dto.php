<?php

namespace App\Data\Abstracts;

use App\Data\Utils\ArrController;
use App\Data\Utils\Property;
use App\Exceptions\DtoErrorException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonMapper;
use JsonMapper_Exception;
use TypeError;

abstract class Dto implements DtoInterface, Arrayable, Jsonable
{
    /**
     * 출력하지 않을 속성들의 배열
     *
     * @var array
     */
    protected array $hidden = [];

    /**
     * 임의 public 속성 추가 방지
     *
     * @param mixed $key
     * @param mixed $value
     * @throws DtoErrorException
     */
    public function __set($key, $value)
    {
        throw new DtoErrorException("{$key}: 유효하지 않는 속성");
    }

    /**
     * Dto constructor.
     * @param null $params
     * @throws JsonMapper_Exception
     */
    public function __construct($params = null)
    {
        $this->map($params);
    }

    /**
     * 배열로 변환
     *
     * @param boolean $allowNull false: allow not null, true: allow null
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
    public function toJson($options = JSON_UNESCAPED_UNICODE, bool $allowNull = true): string
    {
        return json_encode($this->toArray($allowNull), $options);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @param array|Arrayable $data
     * @param bool $clean
     * @return DtoInterface|$this
     * @throws JsonMapper_Exception
     */
    public function map($data, bool $clean = false): DtoInterface
    {
        $self = $this;

        $jsonMapper = new JsonMapper;

        if ($data instanceof Jsonable) {
            $json = json_decode($data->toJson());
            if (is_object($json)) {
                $jsonMapper->map($json, $self);
            }
            return $self;
        }

        if ($data instanceof Arrayable) {
            $json = json_decode(json_encode($data->toArray()));
            if (is_object($json)) {
                $jsonMapper->map($json, $self);
            }
            return $self;
        }

        if (empty($data)) {
            return $self;
        }

        if (!is_object($data) && !is_array($data)) {
            return $self;
        }

        $json = json_decode(json_encode($data));
        if (is_object($json)) {
            $jsonMapper->map($json, $self);
        }

        return $self;
    }

    /**
     * @param $data
     * @return Collection
     * @throws JsonMapper_Exception
     */
    public function mapList($data): Collection
    {
        if (!$data instanceof Arrayable && !is_array($data)) {
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
     * [makeHidden description]
     * toArray() 메서드 작동 시, 숨기고 싶은 속성을 정할 수 있다
     * @param string|array $hidden [$hidden description]
     *
     * @return  DtoInterface|$this          [return description]
     */
    public function makeHidden($hidden): DtoInterface
    {
        $hidden = collect($this->hidden);

        $this->hidden = $hidden->merge($hidden)->all();

        return $this;
    }

    /**
     * [makeVisible description]
     * toArray() 메서드 작동 시, 숨겼던 속성 항목을 다시 출력 시킬 수 있다.
     * @param string|array $visible [$visible description]
     *
     * @return DtoInterface|$this     [return description]
     */
    public function makeVisible($visible): DtoInterface
    {
        $hidden = collect($this->hidden);

        $this->hidden = $hidden->filter(function ($item) use ($visible) {
            $cond = false;
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
        })->all();

        return $this;
    }

    /**
     * Get 출력하지 않을 속성들의 배열
     *
     * @return  array
     */
    public function getHidden(): array
    {
        return $this->hidden;
    }

    /**
     * @param null $params
     * @return DtoInterface|$this
     * @throws JsonMapper_Exception
     */
    public static function newInstance($params = null): DtoInterface
    {
        // TODO: Implement newInstance() method.
        return new static($params);
    }
}
