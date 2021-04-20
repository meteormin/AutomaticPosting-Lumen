<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

// 동적으로 속성을 관리
class FinanceData
{
    /**
     * set 가능한 필드명 정의
     *
     * @var array
     */
    protected $fillable = ['year', 'current_assets', 'total_assets', 'floating_debt', 'total_debt', 'net_income'];

    /**
     * 실제 데이터가 들어가는 배열
     *
     * @var array
     */
    protected $attributes = [];

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
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
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
        if (in_array($key, $this->fillable)) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    /**
     * set attributes
     *
     * @param array $input
     *
     * @return void
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
    public function toArray(bool $allowNull = true): ?array
    {
        return $this->attributes;
    }

    /**
     * mapping account name
     *
     * @return array
     */
    protected static function mapTable(): array
    {
        return [
            'account_nm' => [
                'current_assets' => '유동자산',
                'total_assets' => '자산총계',
                'floating_debt' => '유동부채',
                'total_debt' => '부채총계',
                'net_income' => '당기순이익'
            ],
        ];
    }

    /**
     * mapping
     *
     * @return array
     */
    public static function map($arrayAble, bool $clean = false)
    {
        if ($arrayAble instanceof Arrayable) {
            $arrayAble = $arrayAble->toArray();
        }

        $table = self::mapTable();
        $rsList = collect();

        $current = (new static);
        $prev = (new static);
        $preprev = (new static);

        foreach ($arrayAble as $origin) {
            foreach ($table as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($origin[$key] == $v) {
                        // 당기
                        $current->setAttribute($k, $origin['thstrm_amount'] ?? null);
                        $current->setAttribute('year', $origin['thstrm_dt'] ?? null);

                        // 전기
                        $prev->setAttribute($k, $origin['frmtrm_amount'] ?? null);
                        $prev->setAttribute('year', $origin['frmtrm_dt'] ?? null);

                        // 전전기
                        $preprev->setAttribute($k, $origin['bfefrmtrm_amount'] ?? null);
                        $preprev->setAttribute('year', $origin['bfefrmtrm_dt'] ?? null);
                    }
                }
            }
        }

        $rsList->add($current->toArray());
        $rsList->add($prev->toArray());
        $rsList->add($preprev->toArray());

        return $rsList->toArray();
    }
}
