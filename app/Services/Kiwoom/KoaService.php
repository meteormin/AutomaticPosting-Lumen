<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
use App\Response\ErrorCode;
use App\DataTransferObjects\Utils\Dtos;
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
        $rs = new Dtos;
        foreach ($codes as $code) {
            $rs->add($this->module->get($code)->first());
        }

        return $rs;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return Dtos
     */
    public function showBySector(string $sector)
    {
        $rs = $this->module->getBySector($sector);
        if (is_null($rs)) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, 'not found sector: ' . $sector);
        }

        return $rs;
    }
}
