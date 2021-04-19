<?php

namespace App\Services\Main;

use App\DataTransferObjects\StockInfo;
use App\Services\Service;
use App\Services\Kiwoom\KoaService;
use App\Services\OpenDart\OpenDartService;
use Exception;

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
        $sector = $this->getSectorPriority();

        $stockInfo = $this->koa->showBySector($sector);


        $acnts = collect();
        $rsList = collect();

        set_time_limit(300);

        $stockInfo->each(function ($stock) use (&$acnts, &$rsList) {
            if ($stock instanceof StockInfo) {
                try {
                    $acnts = $this->openDart->getSingle($stock->getCode(), '2020');
                } catch (Exception $e) {
                    $acnts->add([$e->getMessage()]);
                }

                $rsList->add(collect([
                    'stocks' => $stock,
                    'acnts' => $acnts
                ]));
            }
        })->first();

        return $rsList;
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
