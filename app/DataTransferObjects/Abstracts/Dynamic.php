<?php

namespace App\DataTransferObjects\Abstracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;

// 동적으로 속성을 관리
abstract class Dynamic implements Arrayable, Jsonable
{
    /**
     * set 가능한 필드명 정의
     *
     * @var array
     */
    protected static array $fillable = [];

    /**
     * 실제 데이터가 들어가는 배열
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * 새 객체 생성시, 픽스해둔 $fillable의 필드들이
     * snake_case가 아닌 경우, 에러가 발생할 수 있어서
     * 생성자에서 setFillable메서드를 실행시켜 강제로 snake_case로 변환한다.
     */
    public function __construct()
    {
        if (!empty(self::$fillable)) {
            $this->setFillable(self::$fillable);
        }
    }

    /**
     * 동적 getter, setter
     *
     * @param string $name getter or setter method name
     * @param array $args arguments
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (substr($name, 0, 3) == 'get') {
            return $this->getAttribute(Str::snake(substr($name, 3)));
        }

        if (substr($name, 0, 3) == 'set') {
            $this->setAttribute(Str::snake(substr($name, 3)), $args[0]);
            return $this;
        }
    }

    /**
     * 동적 속성 접근
     *
     * @param string $key 속성 명
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }

    /**
     * 동적 속성 값 설정
     *
     * @param string $key 속성 명
     * @param mixed $value 값
     *
     * @return $this
     */
    public function __set(string $key, $value)
    {
        $this->setAttribute($key, $value);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        if (isset($this->attributes[Str::snake($key)])) {
            return $this->attributes[Str::snake($key)];
        }
        return null;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setAttribute(string $key, $value)
    {
        if (in_array(Str::snake($key), self::$fillable)) {
            $this->attributes[Str::snake($key)] = $value;
        }
        return $this;
    }

    public static function setFillable(array $fillable)
    {
        $fillable = collect($fillable)->map(function ($item) {
            return Str::snake($item);
        });

        self::$fillable = $fillable->all();
    }


    public static function getFillable()
    {
        return self::$fillable;
    }

    /**
     * set attributes
     *
     * @param array $input
     *
     * @return $this
     */
    public function fill(array $input)
    {
        foreach ($input as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * return attributes array
     *
     * @param boolean $allowNull
     *
     * @return array|null
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * return to json
     *
     * @param int $options
     *
     * @return void
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->attributes);
    }

    abstract public static function map($input);
}
