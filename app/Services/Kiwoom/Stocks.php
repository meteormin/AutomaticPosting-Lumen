<?php

namespace App\Services\Kiwoom;

use Storage;
use App\Entities\StockInfo;
use Illuminate\Support\Collection;
use App\Services\Libraries\ArrayParser;

class Stocks
{
    /**
     * Undocumented variable
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    protected $path = 'kiwoom';

    public function __construct()
    {
        $this->disk = Storage::disk('local');
        $this->parser = new ArrayParser();
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
    }

    public function get(string $code)
    {
        $stockInfo = new StockInfo;

        $files = Storage::disk('local')->directories('kiwwom');

        foreach ($files as $file) {
            $stock = new ArrayParser($file['stock_data']);
            $stock = $stock->findByAttribute(['stock_code' => $code]);
            if (!$stock->isEmpty()) {
                $stockInfo->map($stock);
                break;
            }
        }

        return $stockInfo;
    }
}
