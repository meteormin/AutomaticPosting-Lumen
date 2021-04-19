<?php

namespace App\Services\Kiwoom;

use Storage;
use Illuminate\Support\Collection;
use App\DataTransferObjects\StockInfo;
use App\DataTransferObjects\Utils\Dtos;

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

    public function put(Collection $stock)
    {
        $rs[] = [
            'sector_code' => $stock->get('sector_code'),
            'sector_name' => $stock->get('sector_name'),
            'result' => $this->disk->put(
                "{$this->path}/{$stock->get('file_name')}.json",
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
     * @return Dtos|null
     */
    public function getBySector(string $sector)
    {
        if ($this->disk->exists($this->path . '/sector_' . $sector . '.json')) {
            $file = json_decode($this->disk->get($this->path . '/sector_' . $sector . '.json'), true);
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
     * @return Dtos
     */
    public function get(string $code = null)
    {
        $res = new Dtos;

        $files = $this->disk->files($this->path);

        foreach ($files as $file) {
            $contents = json_decode($this->disk->get($file), true);

            $stock = collect($contents['stock_data']);
            if (is_null($code)) {
                return $this->stockInfo->mapList($stock);
            } else {
                $stock = $stock->where('code', $code);
                if (!$stock->isEmpty()) {
                    $res->add($this->stockInfo->map($stock->first()));
                    break;
                }
            }
        }

        return $res;
    }
}
