<?php

namespace App\Services\Main;

use App\Services\Service;
use Illuminate\Support\Collection;
use App\Services\Kiwoom\KoaService;
use App\DataTransferObjects\Finance;
use App\DataTransferObjects\StockInfo;
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
        set_time_limit(300);

        $this->koa = $koa;
        $this->openDart = $openDart;
    }

    /**
     * get raw data
     *
     * @param string|null $sector
     *
     * @return Collection
     */
    public function getRawData(string $sector = null)
    {
        if (is_null($sector)) {
            $sector = $this->getSectorPriority();
        }

        $stockInfo = $this->koa->showBySector($sector);

        $acnts = collect();
        $rsList = collect();
        $stockCodes = collect();

        $stockInfo->each(function ($stock) use (&$stockCodes, &$rsList) {
            if ($stock instanceof StockInfo) {
                $stockCodes->add($stock->getCode());
                $finance = new Finance;
                $finance->setStock($stock);
                $rsList->add($finance);
            }
        });

        $acnts = $this->openDart->getMultiple($stockCodes->all(), '2020');

        $rsList->filter(function ($finance) use ($acnts) {
            if ($finance instanceof Finance) {
                $code = $finance->getStock()->getCode();
                $finance->setAcnt($acnts->get($code));
                return true;
            }

            return false;
        });

        return $rsList;
    }

    /**
     * Undocumented function
     *
     * @param string $sector
     *
     * @return Collection
     */
    public function getRefinedData(string $sector = null)
    {
        if (is_null($sector)) {
            $sector = $this->getSectorPriority();
        }

        $rawData = $this->getRawData($sector);

        $refinedData = collect();

        $rawData->each(function ($raw) use (&$refinedData) {
            if ($raw instanceof Finance) {
                if (!is_null($refine = $raw->refine())) {
                    $refinedData->add($refine);
                }
            }
        });

        return $refinedData;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getSectorPriority()
    {
        return '013';
    }
}
