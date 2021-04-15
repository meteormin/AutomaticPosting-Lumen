<?php

namespace  App\Entities\Abstracts;

use JsonMapper;
use App\Entities\Utils\Entities;
use App\Entities\Utils\Property;
use Illuminate\Support\Collection;
use App\Entities\Utils\ArrController;
use App\Exceptions\EntityErrorException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Entity는 DB의 필드 스키마정보를 가지는 객체이다
 * getter는 null 허용 필드가 아닌데 null을 리턴할 경우 에러발생 하도록 처리 할 것
 */
abstract class Entity implements EntityInterface, Arrayable, Jsonable
{
    /**
     * 런타임에서 임의 속성 추가 불가능하게 처리
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     *
     * @throws EntityErrorException
     */
    public function __set($key, $value)
    {
        throw new EntityErrorException("{$key}: 유효하지 않는 속성");
    }

    /**
     * 문자열 변환 매직 함수
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

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
     * json 스트링으로 변환
     *
     * @param  int $options
     * @param  bool $allowNull
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE, $allowNull = false): string
    {
        return json_encode($this->toArray($allowNull), $options);
    }

    /**
     * 새 객체 생성
     *
     * @return self
     */
    public function newInstance()
    {
        return new $this;
    }

    /**
     * clear
     *
     * @return $this
     */
    public function clear()
    {
        $property = new Property($this);

        foreach ($property->toArrayKeys() as $key) {
            $this->$key = null;
        }

        return $this;
    }

    /**
     * map arrayable object
     * JsonMapper 라이브러리 사용
     * @param  Arrayable|array $model
     * @param bool $clean
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
        if ($arrayAble instanceof Arrayable) {

            $jsonMapper->map((object)$arrayAble->toArray(), $self);
            return $this;
        }

        if (is_null($arrayAble) && !is_object($arrayAble) && !is_array($arrayAble)) {
            return $this;
        }

        $jsonMapper->map((object)$arrayAble, $self);

        return $this;
    }

    /**
     * select결과가 여러개일 때 사용됨
     *
     * @param \Illuminate\Support\Collection $datas
     * @return Entities|$this[]
     */
    public function mapList($datas)
    {
        if (!($datas instanceof Collection) && !is_array($datas)) {
            throw new EntityErrorException(get_class($datas) . '은 현재 Entity에서 매핑할 수 없습니다.');
        }

        $rsList = collect();
        foreach ($datas as $data) {
            $entity = $this->newInstance();

            $rsList->add($entity->map($data));
        }

        return new Entities($rsList);
    }

    /**
     * 현재 entity를 모델로 사용
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function toModel(): \Illuminate\Database\Eloquent\Model
    {
        $model = $this->model();
        if (is_null($model)) {
            throw new EntityErrorException(get_class($model) . '모델을 매핑할 수 없습니다.');
        }

        $model->fill($this->toArray());

        return $model;
    }

    /**
     * 모델 객체와 강하게 결합하기 위해 작성
     * \App\Models\{모델명}::class
     * @return string
     */
    abstract protected function getIdentifier(): string;

    /**
     * 모델 객체 가져오기
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function model()
    {
        $model = $this->getIdentifier();

        if (is_null($model)) {
            return null;
        }

        return new $model;
    }
}
