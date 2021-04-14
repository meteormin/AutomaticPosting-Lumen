<?php

namespace App\Entities;

use App\Entities\Abstracts\Entity;

class AcntEntity extends Entity
{
    /**
     * @var int|null $ord
     */
    protected ?int $ord;

    /**
     * @var string|null $rceptNo
     */
    protected ?string $rceptNo;

    /**
     * @var string|null $reptCode
     */
    protected ?string $reptCode;

    /**
     * @var string|null $bsnsYear
     */
    protected ?string $bsnsYear;

    /**
     * @var string|null $corpCode
     */
    protected ?string $corpCode;

    /**
     * @var string|null $sjDiv
     */
    protected ?string $sjDiv;

    /**
     * @var string|null $sjNm;
     */
    protected ?string $sjNm;

    /**
     * @var string|null $stockCode;
     */
    protected ?string $stockCode;

    /**
     * @var string|null $accountId
     */
    protected ?string $accountId;

    /**
     * @var string|null $accountNm
     */
    protected ?string $accountNm;

    /**
     * @var string|null $thstrmAmount
     */
    protected ?string $thstrmAmount;

    /**
     * @var string|null $frmtrmNm
     */
    protected ?string $frmtrmNm;

    /**
     * @var string|null $frmtrmAmount
     */
    protected ?string $frmtrmAmount;

    /**
     * @var string|null $bfefrmtrmNm
     */
    protected ?string $bfefrmtrmNm;

    /**
     * @var string|null $bfefrmtrmAmount
     */
    protected ?string $bfefrmtrmAmount;


    public function getIdentifier(): string
    {
        return 'Acnt';
    }

    /**
     * Get $ord
     *
     * @return  int|null
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set $ord
     *
     * @param  int|null  $ord  $ord
     *
     * @return  self
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get $rceptNo
     *
     * @return  string|null
     */
    public function getRceptNo()
    {
        return $this->rceptNo;
    }

    /**
     * Set $rceptNo
     *
     * @param  string|null  $rceptNo  $rceptNo
     *
     * @return  self
     */
    public function setRceptNo($rceptNo)
    {
        $this->rceptNo = $rceptNo;

        return $this;
    }

    /**
     * Get $reptCode
     *
     * @return  string|null
     */
    public function getReptCode()
    {
        return $this->reptCode;
    }

    /**
     * Set $reptCode
     *
     * @param  string|null  $reptCode  $reptCode
     *
     * @return  self
     */
    public function setReptCode($reptCode)
    {
        $this->reptCode = $reptCode;

        return $this;
    }

    /**
     * Get $bsnsYear
     *
     * @return  string|null
     */
    public function getBsnsYear()
    {
        return $this->bsnsYear;
    }

    /**
     * Set $bsnsYear
     *
     * @param  string|null  $bsnsYear  $bsnsYear
     *
     * @return  self
     */
    public function setBsnsYear($bsnsYear)
    {
        $this->bsnsYear = $bsnsYear;

        return $this;
    }

    /**
     * Get $corpCode
     *
     * @return  string|null
     */
    public function getCorpCode()
    {
        return $this->corpCode;
    }

    /**
     * Set $corpCode
     *
     * @param  string|null  $corpCode  $corpCode
     *
     * @return  self
     */
    public function setCorpCode($corpCode)
    {
        $this->corpCode = $corpCode;

        return $this;
    }

    /**
     * Get $sjDiv
     *
     * @return  string|null
     */
    public function getSjDiv()
    {
        return $this->sjDiv;
    }

    /**
     * Set $sjDiv
     *
     * @param  string|null  $sjDiv  $sjDiv
     *
     * @return  self
     */
    public function setSjDiv($sjDiv)
    {
        $this->sjDiv = $sjDiv;

        return $this;
    }

    /**
     * Get $sjNm;
     *
     * @return  string|null
     */
    public function getSjNm()
    {
        return $this->sjNm;
    }

    /**
     * Set $sjNm;
     *
     * @param  string|null  $sjNm  $sjNm;
     *
     * @return  self
     */
    public function setSjNm($sjNm)
    {
        $this->sjNm = $sjNm;

        return $this;
    }

    /**
     * Get $stockCode;
     *
     * @return  string|null
     */
    public function getStockCode()
    {
        return $this->stockCode;
    }

    /**
     * Set $stockCode;
     *
     * @param  string|null  $stockCode  $stockCode;
     *
     * @return  self
     */
    public function setStockCode($stockCode)
    {
        $this->stockCode = $stockCode;

        return $this;
    }

    /**
     * Get $accountId
     *
     * @return  string|null
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set $accountId
     *
     * @param  string|null  $accountId  $accountId
     *
     * @return  self
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get $accountNm
     *
     * @return  string|null
     */
    public function getAccountNm()
    {
        return $this->accountNm;
    }

    /**
     * Set $accountNm
     *
     * @param  string|null  $accountNm  $accountNm
     *
     * @return  self
     */
    public function setAccountNm($accountNm)
    {
        $this->accountNm = $accountNm;

        return $this;
    }

    /**
     * Get $thstrmAmount
     *
     * @return  string|null
     */
    public function getThstrmAmount()
    {
        return $this->thstrmAmount;
    }

    /**
     * Set $thstrmAmount
     *
     * @param  string|null  $thstrmAmount  $thstrmAmount
     *
     * @return  self
     */
    public function setThstrmAmount($thstrmAmount)
    {
        $this->thstrmAmount = $thstrmAmount;

        return $this;
    }

    /**
     * Get $frmtrmNm
     *
     * @return  string|null
     */
    public function getFrmtrmNm()
    {
        return $this->frmtrmNm;
    }

    /**
     * Set $frmtrmNm
     *
     * @param  string|null  $frmtrmNm  $frmtrmNm
     *
     * @return  self
     */
    public function setFrmtrmNm($frmtrmNm)
    {
        $this->frmtrmNm = $frmtrmNm;

        return $this;
    }

    /**
     * Get $frmtrmAmount
     *
     * @return  string|null
     */
    public function getFrmtrmAmount()
    {
        return $this->frmtrmAmount;
    }

    /**
     * Set $frmtrmAmount
     *
     * @param  string|null  $frmtrmAmount  $frmtrmAmount
     *
     * @return  self
     */
    public function setFrmtrmAmount($frmtrmAmount)
    {
        $this->frmtrmAmount = $frmtrmAmount;

        return $this;
    }

    /**
     * Get $bfefrmtrmNm
     *
     * @return  string|null
     */
    public function getBfefrmtrmNm()
    {
        return $this->bfefrmtrmNm;
    }

    /**
     * Set $bfefrmtrmNm
     *
     * @param  string|null  $bfefrmtrmNm  $bfefrmtrmNm
     *
     * @return  self
     */
    public function setBfefrmtrmNm($bfefrmtrmNm)
    {
        $this->bfefrmtrmNm = $bfefrmtrmNm;

        return $this;
    }

    /**
     * Get $bfefrmtrmAmount
     *
     * @return  string|null
     */
    public function getBfefrmtrmAmount()
    {
        return $this->bfefrmtrmAmount;
    }

    /**
     * Set $bfefrmtrmAmount
     *
     * @param  string|null  $bfefrmtrmAmount  $bfefrmtrmAmount
     *
     * @return  self
     */
    public function setBfefrmtrmAmount($bfefrmtrmAmount)
    {
        $this->bfefrmtrmAmount = $bfefrmtrmAmount;

        return $this;
    }
}
