<?php

namespace App\Services\Main;

use App\DataTransferObjects\Finance;
use App\DataTransferObjects\FinanceData;
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
        set_time_limit(300);

        $this->koa = $koa;
        $this->openDart = $openDart;

        // 필터 조건 정의
        Finance::setFilterAttributeInAcnt([
            'account_nm' => [
                '유동자산',
                '자산총계',
                '유동부채',
                '부채총계',
                '당기순이익'
            ],
            'fs_div' => [
                'CFS'
            ]
        ]);

        // map table 정의
        FinanceData::setMapTable([
            'account_nm' => [
                'current_assets' => '유동자산',
                'total_assets' => '자산총계',
                'floating_debt' => '유동부채',
                'total_debt' => '부채총계',
                'net_income' => '당기순이익'
            ],
        ]);
    }

    /**
     * Undocumented function
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

    public function getRefinedData(string $sector = null)
    {
        if (is_null($sector)) {
            $sector = $this->getSectorPriority();
        }

        $rawData = $this->getRawData($sector);

        $refinedData = collect();

        $rawData->each(function ($raw) use (&$refinedData) {
            if ($raw instanceof Finance) {
                $refinedData->add($raw->refine());
            }
        });

        return $refinedData;
    }

    protected function getSectorPriority()
    {
        return '013';
    }
}
