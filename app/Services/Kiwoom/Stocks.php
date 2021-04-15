<?php

namespace App\Services\Kiwoom;

use Storage;
use App\Entities\StockInfo;
use App\Entities\Utils\Entities;
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

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $path = 'kiwoom';

    /**
     *
     *
     * @var ArrayParser
     */
    protected $parser;

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

    /**
     * Undocumented function
     *
     * @param string $code
     *
     * @return Entities
     */
    public function get(string $code = null)
    {
        $stockInfo = new StockInfo;
        $res = new Entities;

        $files = $this->disk->files($this->path);

        foreach ($files as $file) {
            $contents = $this->disk->get($file);
            $stock = new ArrayParser(json_decode($contents));
            if (is_null($code)) {
                $res->add($stockInfo->map($stock));
            } else {
                $stock = $stock->findByAttribute(['stock_code' => $code]);
                if (!$stock->isEmpty()) {
                    $res->add($stockInfo->map($stock));
                    break;
                }
            }
        }

        return $res;
    }
}
