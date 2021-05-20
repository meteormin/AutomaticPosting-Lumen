<?php

namespace App\Data\DataTransferObjects;

use App\Data\Abstracts\Dto;

class StockInfo extends Dto
{
    /**
     * @var string|null $code
     */
    protected ?string $code;

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
     * Get $code
     *
     * @return  string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set $code
     *
     * @param  mixed $code  $code
     *
     * @return  $this
     */
    public function setCode($code)
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
     * @return  int
     */
    public function getCurrentPrice(): int
    {
        return $this->currentPrice < 0 ?
            $this->currentPrice * (-1) : $this->currentPrice;
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

    public function toArray(bool $allowNull = true): ?array
    {
        return parent::toArray($allowNull);
    }
}
