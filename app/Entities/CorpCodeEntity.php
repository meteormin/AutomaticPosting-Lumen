<?php

namespace App\Entities;

use App\Entities\Abstracts\Entity;

class CorpCodeEntity extends Entity
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
     * @var string $stockCode
     */
    protected string $stockCode;

    /**
     * @var string $modifyDate
     */
    protected string $modifyDate;

    /**
     * Get $corpCode
     *
     * @return  string
     */
    public function getCorpCode()
    {
        return $this->corpCode;
    }

    /**
     * Set $corpCode
     *
     * @param  string  $corpCode  $corpCode
     *
     * @return  self
     */
    public function setCorpCode(string $corpCode)
    {
        $this->corpCode = $corpCode;

        return $this;
    }

    /**
     * Get $corpName
     *
     * @return  string
     */
    public function getCorpName()
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
    public function setCorpName(string $corpName)
    {
        $this->corpName = $corpName;

        return $this;
    }

    /**
     * Get $stockCode
     *
     * @return  string
     */
    public function getStockCode()
    {
        return $this->stockCode;
    }

    /**
     * Set $stockCode
     *
     * @param  string  $stockCode  $stockCode
     *
     * @return  self
     */
    public function setStockCode(string $stockCode)
    {
        $this->stockCode = $stockCode;

        return $this;
    }

    /**
     * Get $modifyDate
     *
     * @return  string
     */
    public function getModifyDate()
    {
        return $this->modifyDate;
    }

    /**
     * Set $modifyDate
     *
     * @param  string  $modifyDate  $modifyDate
     *
     * @return  self
     */
    public function setModifyDate(string $modifyDate)
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    public function getIdentifier(): string
    {
        return '';
    }
}
