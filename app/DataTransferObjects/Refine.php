<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;
use Illuminate\Support\Collection;

class Refine extends Dto
{
    /**
     * @var string $code
     */
    protected string $code;

    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var int $capital
     */
    protected int $capital;

    /**
     * @var int $roe
     */
    protected int $roe;

    /**
     * @var int $per
     */
    protected int $per;

    /**
     * @var int $pbr
     */
    protected int $pbr;

    /**
     * @var int $currentPrice
     */
    protected int $currentPrice;

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
     * Get $code
     *
     * @return  string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set $code
     *
     * @param  string  $code  $code
     *
     * @return  self
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get $name
     *
     * @return  string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param  string  $name  $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get $currentPrice
     *
     * @return string
     */
    public function getCurrentPrice(): string
    {
        return number_format($this->currentPrice);
    }

    /**
     * Set $currentPrice
     *
     * @param  int  $currentPrice  $currentPrice
     *
     * @return  self
     */
    public function setCurrentPrice(int $currentPrice)
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    /**
     * Get $capital
     *
     * @return int
     */
    public function getCapital(): int
    {
        return $this->capital;
    }

    /**
     * Set $capital
     *
     * @param int $capital  $capital
     *
     * @return self
     */
    public function setCapital(int $capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get $roe
     *
     * @return int
     */
    public function getRoe()
    {
        return $this->roe;
    }

    /**
     * Set $roe
     *
     * @param int $roe  $roe
     *
     * @return self
     */
    public function setRoe(int $roe)
    {
        $this->roe = $roe;

        return $this;
    }

    /**
     * Get $per
     *
     * @return int
     */
    public function getPer()
    {
        return $this->per;
    }

    /**
     * Set $per
     *
     * @param int $per  $per
     *
     * @return self
     */
    public function setPer(int $per)
    {
        $this->per = $per;

        return $this;
    }

    /**
     * Get $pbr
     *
     * @return int
     */
    public function getPbr()
    {
        return $this->pbr;
    }

    /**
     * Set $pbr
     *
     * @param int $pbr  $pbr
     *
     * @return self
     */
    public function setPbr(int $pbr)
    {
        $this->pbr = $pbr;

        return $this;
    }

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
     * @param Collection|null
     * @return $this
     */
    public function setFinanceData(?Collection $financeData)
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
