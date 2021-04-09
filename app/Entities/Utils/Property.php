<?php

namespace App\Entities\Utils;

use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;
use Throwable;
use Illuminate\Support\Str;

/**
 * public이 아닌 속성정보와 데이터에 접근하기 위한
 * ReflectionClass 기능을 사용하여 조금 더 쉽게 사용
 */
class Property
{
    /**
     * Object
     *
     * @var Object
     */
    protected $origin;
    /**
     * reflection
     *
     * @var ReflectionClass
     */
    protected $object;

    /**
     * reflection properties
     *
     * @var ReflectionProperty[]
     */
    protected $properties;

    public function __construct(Object $class)
    {
        $this->origin = $class;
        $this->object = new ReflectionObject($class);
        $this->setProperties($this->object->getProperties());
    }


    /**
     * Undocumented function
     * @param ReflectionProperty[] $properties
     * @return $this
     */
    protected function setProperties(array $properties)
    {
        foreach ($properties as $prop) {
            $prop->setAccessible(true);
            $this->properties[] = $prop;
        }

        return $this;
    }

    /**
     * get value of key
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->origin->{'get' . ucfirst($key)}();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->origin->{'set' . ucfirst($key)}($value);

        return $this;
    }

    /**
     * check has property
     *
     * @param string $key
     *
     * @return boolean
     */
    public function hasProperty($key)
    {
        return $this->object->hasProperty($key);
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray()
    {
        $arr = [];
        foreach ($this->properties as $prop) {
            if (method_exists($this->origin, 'get' . Str::studly($prop->getName()))) {
                try {
                    $arr[$prop->getName()] = $this->origin->{'get' . Str::studly($prop->getName())}();
                } catch (Throwable $e) {
                    $arr[$prop->getName()] = null;
                }
            }
        }

        return $arr;
    }

    public function toArrayKeys()
    {
        foreach ($this->properties as $prop) {
            $keys[] = $prop->getName();
        }

        return $keys;
    }
}
