<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

// 동적으로 속성을 관리
class FinanceData
{
    protected $financeData;

    protected $fillable = ['year', 'current_assets', 'floating_debt', 'net_income'];

    protected $attributes = [];

    /**
     * 동적 getter, setter
     *
     * @param string $name
     * @param array $args
     *
     * @return void
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
     * Undocumented function
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @param mixed $value
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

    public function fill(array $input)
    {
        foreach ($input as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function toArray(bool $allowNull = true): ?array
    {
        return $this->attributes;
    }

    protected static function mapTable()
    {
        return [
            'account_nm' => [
                'current_assets' => '유동자산',
                'floating_debt' => '유동부채',
                'net_income' => '당기순이익'
            ],
        ];
    }

    /**
     * map
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
        $current->setAttribute('year', $arrayAble['thstrm_dt']);

        $prev = (new static);
        $prev->setAttribute('year', $arrayAble['frmtrm_dt']);

        $preprev =  (new static);
        $preprev->setAttribute('year', $arrayAble['bfefrmtrm_dt']);

        foreach ($table as $key => $value) {
            foreach ($value as $k => $v) {
                if ($arrayAble[$key] == $v) {
                    // 당기
                    $current->setAttribute($k, $arrayAble['thstrm_amount']);

                    // 전기
                    $prev->setAttribute($k, $arrayAble['frmtrm_amount']);

                    // 전전기
                    $preprev->setAttribute($k, $arrayAble['bfefrmtrm_amount']);
                }
            }
        }

        $rsList->add($current);
        $rsList->add($prev);
        $rsList->add($preprev);

        return $rsList->toArray();
    }
}
