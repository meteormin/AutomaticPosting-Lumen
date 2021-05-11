<?php

namespace App\Data\DataTransferObjects;

use Illuminate\Support\Collection;
use App\Data\Abstracts\Dto;
use JsonMapper_Exception;

class Finance extends Dto
{
    /**
     * @var StockInfo|null $stock
     */
    protected ?StockInfo $stock;

    /**
     * @var Collection|null $acnt
     */
    protected ?Collection $acnt;

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
     * @throws JsonMapper_Exception
     */
    public function __construct(?StockInfo $stock = null, ?Collection $acnt = null)
    {
        parent::__construct();

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
    public function setStock(?StockInfo $stock): Finance
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * get stock info
     *
     * @return StockInfo|null
     */
    public function getStock(): ?string
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
    public function setAcnt($acnt): Finance
    {
        $this->acnt = collect($acnt);
        return $this;
    }

    /**
     * get acnt list
     *
     * @return Collection
     */
    public function getAcnt(): Collection
    {
        return $this->acnt;
    }

    /**
     * 필터 조건:
     * 1차원 요소 AND 조건, 2차원 요소 OR 조건
     *
     * @param array $filters
     *
     * @return $this
     */
    public function setFilterAttributeInAcnt(array $filters): Finance
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
     * @throws JsonMapper_Exception
     */
    public function refine(): ?Refine
    {
        $where = $this->getFilterAttributeInAcnt();
        $acnt = collect($this->getAcnt()->toArray());
        foreach ($where as $attr => $value) {
            $acnt = $acnt->whereIn($attr, $value)->values();
        }

        $refineData = new Refine;
        $refineData->map($this->getStock());
        $refineData->setFinanceData(FinanceData::map($acnt));

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
