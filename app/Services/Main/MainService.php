<?php

namespace App\Services\Main;

use App\DataTransferObjects\StockInfo;
use App\Services\Service;
use App\Services\Kiwoom\KoaService;
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

    /**
     * Undocumented variable
     *
     * @var AnalysisSector
     */
    protected $analysis;

    public function __construct(KoaService $koa, OpenDartService $openDart, AnalysisSector $analysis)
    {
        $this->koa = $koa;
        $this->openDart = $openDart;
        $this->analysis = $analysis;
    }

    public function getRefinedData()
    {
        $sector = $this->analysis->getSectorPriority();

        $stockInfo = $this->koa->showBySector($sector);

        $stock = $stockInfo->filter(function ($stock) {
            if ($stock instanceof StockInfo) {
                if ($stock->getCode() == '005930') {
                }
            }
        })->first();

        $acnt = $this->openDart->getSingle('005930', '2020');

        return [
            'stcok' => $stock,
            'acnt' => $acnt
        ];
    }
}
