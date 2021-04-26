<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Collection;

class Refine extends StockInfo
{
    /**
     * @var Collection
     */
    protected Collection $financeData;

    /**
     * @var int
     */
    protected int $deficitCount;

    /**
     * @var float
     */
    protected int $flowRateAvg;

    /**
     * @var float
     */
    protected int $debtRateAvg;

    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function getFinanceData(): Collection
    {
        return $this->financeData;
    }

    /**
     * Set the value of financeData
     * @param array|null
     * @return $this
     */
    public function setFinanceData(?array $financeData)
    {
        if (is_null($financeData)) {
            $financeData = collect();
        }

        $this->financeData = collect($financeData);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return int
     */
    public function getDeficitCount(): int
    {
        return $this->deficitCount;
    }

    /**
     * Undocumented function
     *
     * @param int|null $deficitCount
     *
     * @return $this
     */
    public function setDeficitCount(?int $deficitCount)
    {
        $this->deficitCount = $deficitCount ?? 0;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return float
     */
    public function getFlowRateAvg(): float
    {
        return $this->flowRateAvg;
    }

    /**
     * Undocumented function
     *
     * @param float $flowRateAvg
     *
     * @return $this
     */
    public function setFlowRateAvg(?float $flowRateAvg)
    {
        $this->flowRateAvg = $flowRateAvg ?? 0.0;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return float
     */
    public function getDebtRateAvg(): float
    {
        return $this->debtRateAvg;
    }

    /**
     * Undocumented function
     *
     * @param float|null $debtRateAvg
     *
     * @return $this
     */
    public function setDebtRateAvg(?float $debtRateAvg)
    {
        $this->debtRateAvg = $debtRateAvg ?? 0.0;

        return $this;
    }
}
