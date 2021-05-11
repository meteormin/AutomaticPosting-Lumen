<?php

namespace App\Services\Kiwoom;

use TypeError;
use App\Services\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class KoaService extends Service
{
    /**
     * Undocumented variable
     *
     * @var Stocks
     */
    protected $module;

    public function __construct(Stocks $module)
    {
        $this->module = $module;
    }

    /**
     * Undocumented function
     * @param string $name
     * @param Collection $stocks
     *
     * @return Collection
     */
    public function storeStock(string $name, Collection $stocks)
    {
        $rs = collect();

        $stocks->each(function ($item) use ($name, &$rs) {
            $rs->add($this->module->put($name, $item));
        });

        if ($rs->count() == 0) {
            $this->throw(self::CONFLICT, '섹터 별 주가정보 저장 실패, ' . $stocks->get('stock_code'));
        }

        return $rs;
    }

    /**
     *
     * @param string $name
     * @param array $codes
     *
     * @return Collection
     */
    public function showStock(string $name, array $codes = null)
    {
        if (empty($codes)) {
            return $this->module->get($name);
        }

        $rs = collect();
        foreach ($codes as $code) {
            $rs->add($this->module->get($name, $code)->first());
        }

        return $rs;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return collection
     */
    public function showBySector(string $sector)
    {
        $rs = $this->module->getBySector($sector);
        if (is_null($rs)) {
            $this->throw(self::RESOURCE_NOT_FOUND, 'not found sector: ' . $sector);
        }

        return $rs;
    }

    /**
     * Undocumented function
     *
     * @param string $theme
     *
     * @return collection
     */
    public function showByTheme(string $theme)
    {
        $rs = $this->module->getByTheme($theme);
        if (is_null($rs)) {
            $this->throw(self::RESOURCE_NOT_FOUND, 'not found theme: ' . $theme);
        }

        return $rs;
    }

    public function storeThemes(string $market, ?array $data)
    {
        return $this->storeConfig('theme', $market, $data);
    }

    public function storeSectors(string $market, ?array $data)
    {
        return $this->storeConfig('sector', $market, $data);
    }

    public function storeConfig(string $type, string $market, ?array $data)
    {
        if (!($type == 'sector' || $type == 'theme')) {
            throw new TypeError("type parameter is enum('sector','theme')");
        }

        $type = Str::plural($type);

        $file = base_path("resources/lang/ko/{$type}.json");

        $data = collect($data);

        if ($data->isEmpty()) {
            $this->throw(self::VALIDATION_FAIL, 'data is empty');
        }

        $raw = collect();

        $data->each(function ($item) use (&$raw) {
            $raw->put($item['code'], $item['name']);
        });

        switch ($market) {
            case 0:
                $marketCode = 0;
                break;
            default:
                $marketCode = 0;
                break;
        }

        $contents = [
            $market => [
                'market_code' => $marketCode,
                "{$type}" => $data,
                "{$type}_raw" => $raw
            ]
        ];

        return file_put_contents($file, json_encode($contents, JSON_UNESCAPED_UNICODE));
    }
}
