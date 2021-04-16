<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;

class StockInfo extends Dto
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
     * @var int $currentPrice
     */
    protected int $currentPrice;

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
     * @return  int
     */
    public function getCurrentPrice(): int
    {
        return $this->currentPrice;
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
}
