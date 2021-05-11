<?php

namespace App\Data\DataTransferObjects;

use App\Data\Abstracts\Dto;

class CorpCode extends Dto
{
    /**
     * @var string $corpCode
     */
    protected string $corpCode;

    /**
     * @var string $corpName
     */
    protected string $corpName;

    /**
     * @var mixed $stockCode
     */
    protected $stockCode;

    /**
     * @var string $modifyDate
     */
    protected string $modifyDate;

    /**
     * Get $corpCode
     *
     * @return  string
     */
    public function getCorpCode(): string
    {
        return $this->corpCode;
    }

    /**
     * @param string $corpCode
     * @return $this
     */
    public function setCorpCode(string $corpCode): CorpCode
    {
        $this->corpCode = $corpCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorpName(): string
    {
        return $this->corpName;
    }

    /**
     * Set $corpName
     *
     * @param  string  $corpName  $corpName
     *
     * @return  self
     */
    public function setCorpName(string $corpName): CorpCode
    {
        $this->corpName = $corpName;

        return $this;
    }

    /**
     * Get $stockCode
     *
     * @return  mixed
     */
    public function getStockCode()
    {
        return $this->stockCode;
    }

    /**
     * Set $stockCode
     *
     * @param  mixed  $stockCode  $stockCode
     *
     * @return  $this
     */
    public function setStockCode($stockCode = null): CorpCode
    {
        $this->stockCode = $stockCode;

        return $this;
    }

    /**
     * Get $modifyDate
     *
     * @return  string
     */
    public function getModifyDate(): string
    {
        return $this->modifyDate;
    }

    /**
     * Set $modifyDate
     *
     * @param  string  $modifyDate  $modifyDate
     *
     * @return $this
     */
    public function setModifyDate(string $modifyDate): CorpCode
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    public function toArray(bool $allowNull = true): ?array
    {
        return parent::toArray($allowNull);
    }
}
