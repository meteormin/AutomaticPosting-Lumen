<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
use App\Entities\StockInfo;
use App\Response\ErrorCode;
use App\Entities\Utils\Entities;
use Illuminate\Support\Collection;
use App\Services\Libraries\ArrayParser;
use Illuminate\Support\Facades\Storage;

class KoaService extends Service
{
    /**
     * Undocumented variable
     *
     * @var Stocks
     */
    protected $module;

    public function __construct()
    {
        $this->module = new Stocks;
    }

    /**
     * Undocumented function
     *
     * @param Collection $stocks
     *
     * @return Collection
     */
    public function storeStock(Collection $stocks)
    {
        $rs = collect();

        $stocks->each(function ($item) use (&$rs) {
            $rs->add($this->module->put($item));
        });

        if (count($rs) == 0) {
            $this->throw(ErrorCode::CONFLICT, '섹터 별 주가정보 저장 실패, ' . $stocks->get('stock_code'));
        }

        return $rs;
    }

    public function showStock(string $code = null)
    {
        if (is_null($code)) {
            return $this->module->get();
        }

        $codes = explode(',', $code);
        $rs = new Entities;
        foreach ($codes as $code) {
            $rs->add($this->module->get($code)->first());
        }

        return $rs;
    }
}
