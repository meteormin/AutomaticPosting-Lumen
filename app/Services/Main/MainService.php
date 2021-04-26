<?php

namespace App\Services\Main;

use App\Services\Service;
use App\Services\Kiwoom\KoaService;
use App\DataTransferObjects\Finance;
use App\DataTransferObjects\StockInfo;
use App\DataTransferObjects\Utils\Dtos;
use App\DataTransferObjects\FinanceData;
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

        /**
         * 필터 조건 정의
         * 1차원 배열 -> and 조건
         * 2차원 배열 -> or 조건
         * account_nm 필드 값이 [유동자산,자산총계,유동부채,부채총계,당기순이익]
         * AND
         * fs_div 필드 값이 [CFS]
         */
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

        // FinanceData has Dynamic Property and Dynamic setter, getter
        // 속성 설정, 정의한 속성만 채워 넣을 수 있다.
        FinanceData::setFillable([
            'date', 'current_assets', 'total_assets', 'floating_debt', 'total_debt', 'net_income', 'flow_rate', 'debt_rate'
        ]);

        /**
         * set MapTable
         * account_nm의 값이 [유동자산,자산총계,유동부채,부채총계,당기순이익]인, 객체를
         * 필요한 값만 뽑아, 객체가 아닌 하나의 속성(필드)로 재구성
         */
        FinanceData::setMapTable([
            'account_nm' => [
                'current_assets' => '유동자산',
                'total_assets' => '자산총계',
                'floating_debt' => '유동부채',
                'total_debt' => '부채총계',
                'net_income' => '당기순이익'
            ]
        ]);
    }

    /**
     * get raw data
     *
     * @param string|null $sector
     *
     * @return Dtos
     */
    public function getRawData(string $sector = null)
    {
        if (is_null($sector)) {
            $sector = $this->getSectorPriority();
        }

        $stockInfo = $this->koa->showBySector($sector);

        $acnts = new Dtos();
        $rsList = new Dtos();
        $stockCodes = new Dtos();

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
     * @return Dtos
     */
    public function getRefinedData(string $sector = null)
    {
        if (is_null($sector)) {
            $sector = $this->getSectorPriority();
        }

        $rawData = $this->getRawData($sector);

        $refinedData = new Dtos();

        $rawData->each(function ($raw) use (&$refinedData) {
            if ($raw instanceof Finance) {
                $refinedData->add($raw->refine());
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
