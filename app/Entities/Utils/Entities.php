<?php

namespace  App\Entities\Utils;

use ArrayAccess;
use Illuminate\Support\Collection;

/**
 * Entities
 * 라라벨 컬렉션을 확장(상속)
 * Entity객체리스트를 라라벨 컬렉션의 내장 기능을 활용하여 보다 쉽게 컨트롤
 */
class Entities extends Collection
{
    /**
     * Undocumented variable
     *
     * @var EntityInterface[]
     */
    protected $items = [];

    /**
     * @param \Illuminate\Support\Collection|EntityInterface[] $entities
     */
    public function __construct($entities = [])
    {
        if (is_array($entities) || ($entities instanceof ArrayAccess)) {
            parent::__construct($entities);
        }
    }
}
