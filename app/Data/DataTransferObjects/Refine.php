<?php

namespace App\Data\DataTransferObjects;

use Miniyus\Mapper\Data\Dto;
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

    protected int $netIncome;

    /**
     * @var int
     */
    protected int $deficitCount;

    /**
     * @var float
     */
    protected float $flowRateAvg;

    /**
     * @var float
     */
    protected float $debtRateAvg;

    /**
     * @return int
     */
    public function getNetIncome(): int
    {
        return $this->netIncome;
    }

    /**
     * @param int $netIncome
     * @return Refine
     */
    public function setNetIncome(int $netIncome): Refine
    {
        $this->netIncome = $netIncome;
        return $this;
    }

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
     * @return  $this
     */
    public function setCode(string $code): Refine
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
     * @return $this
     */
    public function setName(string $name): Refine
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
     * @return $this
     */
    public function setCurrentPrice(int $currentPrice): Refine
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
     * @return $this
     */
    public function setCapital(int $capital): Refine
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get $roe
     *
     * @return int
     */
    public function getRoe(): int
    {
        return $this->roe;
    }

    /**
     * Set $roe
     *
     * @param int $roe  $roe
     *
     * @return $this
     */
    public function setRoe(int $roe): Refine
    {
        $this->roe = $roe;

        return $this;
    }

    /**
     * Get $per
     *
     * @return int
     */
    public function getPer(): int
    {
        return $this->per;
    }

    /**
     * Set $per
     *
     * @param int $per  $per
     *
     * @return $this
     */
    public function setPer(int $per): Refine
    {
        $this->per = $per;

        return $this;
    }

    /**
     * Get $pbr
     *
     * @return int
     */
    public function getPbr(): int
    {
        return $this->pbr;
    }

    /**
     * Set $pbr
     *
     * @param int $pbr  $pbr
     *
     * @return $this
     */
    public function setPbr(int $pbr): Refine
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
     * @param Collection|null $financeData
     * @return $this
     */
    public function setFinanceData(?Collection $financeData): Refine
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
    public function setDeficitCount(?int $deficitCount): Refine
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
     * @param float|null $flowRateAvg
     *
     * @return $this
     */
    public function setFlowRateAvg(?float $flowRateAvg): Refine
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
    public function setDebtRateAvg(?float $debtRateAvg): Refine
    {
        $this->debtRateAvg = $debtRateAvg ?? 0.0;

        return $this;
    }

    public function toArray(bool $allowNull = true): ?array
    {
        return parent::toArray($allowNull);
    }
}
