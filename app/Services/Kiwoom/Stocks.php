<?php

namespace App\Services\Kiwoom;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use JsonMapper_Exception;
use Storage;
use Illuminate\Support\Collection;
use App\Data\DataTransferObjects\StockInfo;

class Stocks
{
    /**
     * Undocumented variable
     *
     * @var Filesystem
     */
    protected $disk;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected string $path;

    /**
     *
     *
     * @var Collection
     */
    protected Collection $sectors;

    /**
     * Undocumented variable
     *
     * @var StockInfo
     */
    protected StockInfo $stockInfo;

    public function __construct(StockInfo $stockInfo)
    {
        $this->disk = Storage::disk('local');
        $this->sectors = collect(config('sectors'));
        $this->stockInfo = $stockInfo;
        $this->path = 'kiwoom';
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param Collection $stock
     *
     * @return Collection
     */
    public function put(string $name, Collection $stock): Collection
    {
        return collect([
            "{$name}_code" => $stock->get("{$name}_code"),
            "{$name}_name" => $stock->get("{$name}_name"),
            'result' => $this->disk->put(
                "{$this->path}/{$name}/{$stock->get('file_name')}.json",
                $stock->except('file_name')->toJson(JSON_UNESCAPED_UNICODE)
            )
        ]);
    }

    /**
     * Undocumented function
     * @param string
     * @return Collection
     */
    protected function sectors(): Collection
    {
        return $this->sectors;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return Collection|null
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getBySector(string $sector): ?Collection
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
     * @return Collection|null
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getByTheme(string $theme): ?Collection
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
     *
     * Undocumented function
     *
     * @param string $name
     * @param string|null $code
     *
     * @return Collection
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function get(string $name, string $code = null): Collection
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
