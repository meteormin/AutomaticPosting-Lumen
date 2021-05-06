<?php

namespace App\DataTransferObjects\Abstracts;

use App\Exceptions\DtoErrorException;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use App\DataTransferObjects\Utils\BaseObject;

abstract class Dto extends BaseObject implements DtoInterface, Arrayable, Jsonable
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

    public function __construct($params = null)
    {
        return $this->map($params);
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
    public function toArray(bool $allowNull = false): ?array
    {
        $attributes = collect(parent::toArray($allowNull));

        $attributes = $attributes->except(array_merge(['hidden'], $this->hidden));

        return $attributes->isEmpty() ? null : $attributes->all();
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
     * Get 출력하지 않을 속성들의 배열
     *
     * @return  array
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
