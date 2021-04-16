<?php

namespace App\DataTransferObjects\Utils;

use ArrayAccess;
use Illuminate\Support\Collection;
use App\DataTransferObjects\Abstracts\DtoInterface;

/**
 * Dtos
 * 라라벨 컬렉션을 확장(상속)
 * Dto객체리스트를 라라벨 컬렉션의 내장 기능을 활용하여 보다 쉽게 컨트롤
 */
class Dtos extends Collection
{

    /**
     * @var DtoInterface[]
     */
    protected $items = [];

    protected $hidden = [];

    /**
     * @param \Illuminate\Support\Collection|DtoInterface[] $dtos Dto리스트(컬렉션)
     */
    public function __construct($dtos = [])
    {
        if (is_array($dtos) || ($dtos instanceof ArrayAccess)) {
            parent::__construct($dtos);
        }
    }

    /**
     * makeHidden
     * toArray, toJson, __toString 메서드를 통한 출력결과에서 숨길 속성을 정의할 수 있다
     * @param array|string $hidden
     *
     * @return $this
     */
    public function makeHidden($hidden)
    {
        $this->hidden = collect($this->hidden);

        $this->hidden = $this->hidden->merge($hidden)->all();

        $this->items = $this->map(function ($item) {
            if ($item instanceof DtoInterface) {
                return $item->makeHidden($this->hidden);
            }

            return null;
        })->all();

        return $this;
    }

    /**
     * makeVisible
     * makeHidden 메서드에서 숨긴 속성을 다시 출력 가능하게
     * @param array|string $visible
     *
     * @return $this
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

        $this->items = $this->map(function ($item) {
            if ($item instanceof DtoInterface) {
                return $item->makeVisible($this->hidden);
            }

            return null;
        });

        return $this;
    }

    /**
     * echo 출력 가능
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * toArray
     *
     * @param boolean $accpetNull null허용여부(true/false)
     *
     * @return array
     */
    public function toArray(bool $accpetNull = false)
    {
        return $this->map(function ($item) use ($accpetNull) {
            if ($item instanceof DtoInterface) {
                return $item->toArray($accpetNull);
            }
            return null;
        })->all();
    }

    /**
     * toJson
     *
     * @param int $options json_encode 옵션 설정
     * @param boolean $accpetNull null허용여부(true/false)
     *
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE, bool $accpetNull = false)
    {
        return json_encode($this->toArray($accpetNull), $options);
    }
}
