<?php

namespace App\Services\Main;

use Exception;
use App\Services\Service;
use App\Services\Kiwoom\KoaService;
use App\DataTransferObjects\StockInfo;
use App\DataTransferObjects\Utils\Dtos;
use App\Services\OpenDart\OpenDartService;

class MainService extends Service
{
    /**
     * Undocumented variable
     *
     * @var KoaService
     */
    protected $koa;

    /**
     * Undocumented variable
     *
     * @var OpenDartService
     */
    protected $openDart;

    public function __construct(KoaService $koa, OpenDartService $openDart)
    {
        $this->koa = $koa;
        $this->openDart = $openDart;
    }

    public function getRawData()
    {
        set_time_limit(300);

        $sector = $this->getSectorPriority();
        $stockInfo = $this->koa->showBySector($sector);

        $acnts = collect();
        $rsList = collect();
        $stockCodes = collect();

        $stockInfo->each(function ($stock) use (&$stockCodes, &$rsList) {
            if ($stock instanceof StockInfo) {
                $stockCodes->add($stock->getCode());
                $rsList->put($stock->getCode(), new Dtos());
                $rsList->get($stock->getCode())->put('stock', $stock);
            }
        });

        $acnts = $this->openDart->getMultiple($stockCodes->all(), '2020');

        $stockCodes->each(function ($code) use (&$acnts, &$rsList) {
            $rsList->get($code)->put('acnt', $acnts->get($code));
        });

        return $rsList->values();
    }

    public function getRefinedData()
    {
        $sector = $this->getSectorPriority();

        $stockInfo = $this->koa->showBySector($sector);

        $stock = $stockInfo->filter(function ($stock) {
            if ($stock instanceof StockInfo) {
                if ($stock->getCode() == '005930') {
                    return $stock;
                }
            }
        })->first();

        $acnt = $this->openDart->getSingle('005930', '2020');

        return collect([
            'stcok' => $stock,
            'acnt' => $acnt
        ]);
    }

    protected function getSectorPriority()
    {
        // $sectors = config('sectors');
        // $sectors = $sectors['kospi'];
        // $sectors = collect($sectors['sectors']);
        // $stocks = null;
        // $sectors->each(function ($sector) use (&$stocks) {
        //     $stocks = $this->koa->showBySector($sector);
        // });
        // $this->stocks = $stocks;

        // if (!is_null($stocks)) {
        //     $acnts = collect();
        //     $stocks->each(function ($stock) use (&$acnts) {
        //         $acnts->add($this->openDart->getSingle($stock->getCode()));
        //     });
        //     $this->acnts = $acnts;
        // }

        // 분석하기

        // 임시, 일단 전자기기로 고정
        return '013';
    }
}
