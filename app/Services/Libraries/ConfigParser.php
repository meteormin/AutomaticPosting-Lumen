<?php

namespace App\Libraries\MapperV2;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

/**
 * config parser
 */
class ConfigParser extends Collection
{
    /**
     * attributes
     * @var string[]
     */
    protected $items = [];

    public function __construct(string $configName)
    {
        $this->items = config($configName);
    }

    /**
     * find key by class name
     *
     * @param string $attr
     *
     * @return string
     */
    public function findKeyByAttribute(string $attr)
    {
        $found = $this->match($attr);

        return  collect($found)->keys()->first();
    }

    /**
     * Undocumented function
     *
     * @param array|string $attributes
     * @param string $value
     *
     * @return collection
     */
    public function findByAttribute($attributes, string $value = null)
    {
        $found = [];

        if (is_array($attributes)) {
            foreach ($attributes as $key => $attr) {

                $value = $this->where($key, $attr);

                if (is_array($value)) {
                    $found = [$attr => $value];
                } else {
                    $found = [$key => $value];
                }
            }
            return collect($found);
        } else if (is_string($attributes)) {
            return $this->where($attributes, $value);
        }

        return null;
    }

    /**
     * match key by class name
     *
     * @param string $attr
     *
     * @return array
     */
    protected function match(string $attr)
    {
        return Arr::where($this->config, function ($value, $key) use ($attr) {
            if ($key == $attr) {
                return true;
            }

            $data = Arr::where($value, function ($v) use ($attr) {
                return $v == $attr;
            });

            if (count($data) == 0) {
                return false;
            }

            return true;
        });
    }
}
