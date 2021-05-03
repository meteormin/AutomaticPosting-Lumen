<?php

namespace App\Services\Kiwoom;

use Storage;
use Illuminate\Support\Collection;
use App\DataTransferObjects\StockInfo;

class Stocks
{
    /**
     * Undocumented variable
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $path;

    /**
     *
     *
     * @var Collection
     */
    protected $sectors;

    /**
     * Undocumented variable
     *
     * @var StockInfo
     */
    protected $stockInfo;

    public function __construct(StockInfo $stockInfo)
    {
        $this->disk = Storage::disk('local');
        $this->sectors = collect(config('sectors'));
        $this->stockInfo = $stockInfo;
        $this->path = 'kiwoom';
    }

    public function put($name, Collection $stock)
    {
        $rs[] = [
            "{$name}_code" => $stock->get("{$name}_code"),
            "{$name}_name" => $stock->get("{$name}_name"),
            'result' => $this->disk->put(
                "{$this->path}/{$name}/{$stock->get('file_name')}.json",
                $stock->except('file_name')->toJson(JSON_UNESCAPED_UNICODE)
            )
        ];

        return $rs;
    }

    /**
     * Undocumented function
     * @param string
     * @return Collection
     */
    protected function sectors()
    {
        return $this->sectors;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return Collection|null
     */
    public function getBySector(string $sector)
    {
        $file = $this->path . '/sector/sector_' . $sector . '.json';
        if ($this->disk->exists($file)) {
            $file = json_decode($this->disk->get($file), true);
            return $this->stockInfo->mapList(collect($file['stock_data']));
        } else {
            return null;
        }
    }

    /**
     * Undocumented function
     *
     * @param string $theme
     *
     * @return void
     */
    public function getByTheme(string $theme)
    {
        $file = $this->path . '/theme/theme_' . $theme . '.json';
        if ($this->disk->exists($file)) {
            $file = json_decode($this->disk->get($file), true);
            return $this->stockInfo->mapList(collect($file['stock_data']));
        } else {
            return null;
        }
    }

    /**
     * Undocumented function
     *
     * @param string $code
     *
     * @return Collection
     */
    public function get(string $name, string $code = null)
    {
        $res = collect();

        $files = $this->disk->files($this->path . '/' . $name);

        foreach ($files as $file) {
            $contents = json_decode($this->disk->get($file), true);

            $stock = collect($contents['stock_data']);
            if (is_null($code)) {
                return $this->stockInfo->mapList($stock);
            } else {
                $stock = $stock->where('code', $code);
                if (!$stock->isEmpty()) {
                    $res->add($this->stockInfo->map($stock->first(), true));
                }
            }
        }

        return $res;
    }
}
