<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Utils\Dtos;
use App\DataTransferObjects\Abstracts\Dto;

class Finance extends Dto
{
    /**
     * @var StockInfo|null $stock
     */
    protected $stock;

    /**
     * @var Dtos|null $acnt
     */
    protected $acnt;

    /**
     * 재무정보 filter 조건
     *
     * @var array
     */
    protected array $filters = [
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
    ];

    /**
     * construct
     *
     * @param StockInfo|null $stock
     * @param Dtos|null $acnt
     */
    public function __construct(?StockInfo $stock = null, ?Dtos $acnt = null)
    {
        $this->stock = $stock;
        $this->acnt = $acnt;
    }

    /**
     * set stock info
     *
     * @param StockInfo|null $stock
     *
     * @return $this
     */
    public function setStock(?StockInfo $stock)
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * get stock info
     *
     * @return StockInfo|null
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * set acnt list
     *
     * @param Dtos|Acnt[]|null $acnt
     *
     * @return $this
     */
    public function setAcnt($acnt)
    {
        $this->acnt = new Dtos($acnt);
        return $this;
    }

    /**
     * get acnt list
     *
     * @return Dtos|Acnt[]
     */
    public function getAcnt()
    {
        return $this->acnt;
    }

    /**
     * 필터 조건:
     * 1차원 요소 AND 조건, 2차원 요소 OR 조건
     *
     * @param array $filters
     *
     * @return void
     */
    public function setFilterAttributeInAcnt(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * 필터 조건
     * 1차원 요소 AND 조건
     * 2차원 요소 OR 조건
     *
     * @return array
     */
    protected function getFilterAttributeInAcnt(): array
    {
        return $this->filters;
    }

    public function toArray(bool $allowNull = true): ?array
    {
        $where = $this->getFilterAttributeInAcnt();

        $acnt = collect($this->getAcnt()->toArray());
        foreach ($where as $attr => $value) {
            $acnt = $acnt->whereIn($attr, $value)->values();
        }

        $rsList = collect($this->getStock()->toArray());
        $rsList->put('finance_data', $acnt);

        return $rsList->toArray();
    }

    public function refine()
    {
        $raw = $this->toArray();

        $raw['finance_data'] = FinanceData::map($raw['finance_data']);

        $refineData = collect($raw);

        $refineData->get('finance_data')->each(function ($item) use (&$refineData) {
            $dataCnt = 0;

            $data = new FinanceData($item);

            $deficitCnt = 0;
            $flowRateAvg = 0;
            $debtRateAvg = 0;
            $dataCnt++;

            if ($data->getNetIncome() <= 0) {
                $deficitCnt++;
            }

            $refineData->put('deficit_count', $deficitCnt);

            if (!is_null($data->getFlowRate())) {
                $flowRateAvg += $data->getFlowRate();
            }

            if (!is_null($data->getDebtRate())) {
                $debtRateAvg += $data->getDebtRate();
            }

            $refineData->put('flow_rate_avg', (float)($flowRateAvg / $dataCnt));
            $refineData->put('debt_rate_avg', (float)($debtRateAvg / $dataCnt));
        });

        return $refineData;
    }
}
