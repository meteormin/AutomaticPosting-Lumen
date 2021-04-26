<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Collection;
use App\DataTransferObjects\Abstracts\Dto;

class Finance extends Dto
{
    /**
     * @var StockInfo|null $stock
     */
    protected $stock;

    /**
     * @var Collection|null $acnt
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
     * @param Collection|null $acnt
     */
    public function __construct(?StockInfo $stock = null, ?Collection $acnt = null)
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
     * @param Collection|Acnt[]|null $acnt
     *
     * @return $this
     */
    public function setAcnt($acnt)
    {
        $this->acnt = collect($acnt);
        return $this;
    }

    /**
     * get acnt list
     *
     * @return Collection|Acnt[]
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

    /**
     * Undocumented function
     *
     * @return Refine|null
     */
    public function refine()
    {
        $raw = collect($this->toArray());

        $raw->put('finance_data', FinanceData::map($raw['finance_data']));

        $refineData = new Refine;

        $refineData->setFinanceData($raw->get('finance_data'));

        if ($refineData->getFinanceData()->isEmpty()) {
            return null;
        }

        $dataCnt = 0;
        $deficitCnt = 0;
        $flowRateSum = 0;
        $debtRateSum = 0;

        $refineData->getFinanceData()->each(function ($item) use (&$dataCnt, &$deficitCnt, &$flowRateSum, &$debtRateSum) {
            if ($item instanceof FinanceData) {
                $data = $item;
            } else {
                $data = new FinanceData($item);
            }

            if ($data->getNetIncome() <= 0) {
                $deficitCnt++;
            }
            if (is_numeric($data->getFlowRate())) {
                $flowRateSum += $data->getFlowRate();
            }

            if (is_numeric($data->getDebtRate())) {
                $debtRateSum += $data->getDebtRate();
            }

            $dataCnt++;
        });

        $refineData->setDeficitCount($deficitCnt);
        $refineData->setFlowRateAvg((float)($flowRateSum / $dataCnt));
        $refineData->setDebtRateAvg((float)($debtRateSum / $dataCnt));

        return $refineData;
    }
}
