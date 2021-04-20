<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;

class Acnt extends Dto
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
     * 사업 년도
     * @var string|null $bsnsYear
     */
    protected ?string $bsnsYear;

    /**
     * 회사 고유 번호
     * @var string|null $corpCode
     */
    protected ?string $corpCode;

    /**
     * 종목코드
     * @var string|null $stockCode;
     */
    protected ?string $stockCode;

    /**
     * 개별/연결구분
     * @var string|null
     */
    protected ?string $fsDiv;

    /**
     * 개별/연결명
     * @var string|null
     */
    protected ?string $fsNm;

    /**
     * 재무제표구분
     * @var string|null $sjDiv
     */
    protected ?string $sjDiv;

    /**
     * 재무제표명
     * @var string|null $sjNm;
     */
    protected ?string $sjNm;

    /**
     * 계정 ID
     * @var string|null $accountId
     */
    protected ?string $accountId;

    /**
     * 계정 명
     * @var string|null $accountNm
     */
    protected ?string $accountNm;

    /**
     * 당기 명
     * @var string|null $thstrmNm
     */
    protected ?string $thstrmNm;

    /**
     * 당기일자
     * @var string|null $thstrmDt
     */
    protected ?string $thstrmDt;

    /**
     * 당기금액
     * @var string|null $thstrmAmount
     */
    protected ?string $thstrmAmount;

    /**
     * 당기누적금액
     * @var string|null $thstrmAddAmount
     */
    protected ?string $thstrmAddAmount;

    /**
     * 전기명
     * @var string|null $frmtrmNm
     */
    protected ?string $frmtrmNm;

    /**
     * 전기날짜
     * @var string|null $frmtrmDt
     */
    protected ?string $frmtrmDt;

    /**
     * 전기금액
     * @var string|null $frmtrmAmount
     */
    protected ?string $frmtrmAmount;

    /**
     * 전기 누적금액
     * @var string|null $frmtrmAddAmount
     */
    protected ?string $frmtrmAddAmount;

    /**
     * 전전기명
     * @var string|null $bfefrmtrmNm
     */
    protected ?string $bfefrmtrmNm;

    /**
     * 전전기일자
     * @var string|null $bfefrmtrmDt
     */
    protected ?string $bfefrmtrmDt;

    /**
     * 전전기금액
     * @var string|null $bfefrmtrmAmount
     */
    protected ?string $bfefrmtrmAmount;

    /**
     * Get $ord
     *
     * @return int|null
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set $ord
     *
     * @param int|null $ord  $ord
     *
     * @return self
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get $rceptNo
     *
     * @return string|null
     */
    public function getRceptNo()
    {
        return $this->rceptNo;
    }

    /**
     * Set $rceptNo
     *
     * @param string|null $rceptNo  $rceptNo
     *
     * @return self
     */
    public function setRceptNo($rceptNo)
    {
        $this->rceptNo = $rceptNo;

        return $this;
    }

    /**
     * Get $reptCode
     *
     * @return string|null
     */
    public function getReptCode()
    {
        return $this->reptCode;
    }

    /**
     * Set $reptCode
     *
     * @param string|null $reptCode  $reptCode
     *
     * @return self
     */
    public function setReptCode($reptCode)
    {
        $this->reptCode = $reptCode;

        return $this;
    }

    /**
     * Get $bsnsYear
     *
     * @return string|null
     */
    public function getBsnsYear()
    {
        return $this->bsnsYear;
    }

    /**
     * Set $bsnsYear
     *
     * @param string|null $bsnsYear  $bsnsYear
     *
     * @return self
     */
    public function setBsnsYear($bsnsYear)
    {
        $this->bsnsYear = $bsnsYear;

        return $this;
    }

    /**
     * Get $corpCode
     *
     * @return string|null
     */
    public function getCorpCode()
    {
        return $this->corpCode;
    }

    /**
     * Set $corpCode
     *
     * @param string|null $corpCode  $corpCode
     *
     * @return self
     */
    public function setCorpCode($corpCode)
    {
        $this->corpCode = $corpCode;

        return $this;
    }

    /**
     * Get $stockCode;
     *
     * @return string|null
     */
    public function getStockCode()
    {
        return $this->stockCode;
    }

    /**
     * Set $stockCode;
     *
     * @param string|null $stockCode  $stockCode;
     *
     * @return self
     */
    public function setStockCode($stockCode)
    {
        $this->stockCode = $stockCode;

        return $this;
    }

    /**
     * Get 개별/연결구분
     *
     * @return string|null
     */
    public function getFsDiv()
    {
        return $this->fsDiv;
    }

    /**
     * Set 개별/연결구분
     *
     * @param string|null $fsDiv  개별/연결구분
     *
     * @return self
     */
    public function setFsDiv($fsDiv)
    {
        $this->fsDiv = $fsDiv;

        return $this;
    }

    /**
     * Get 개별/연결명
     *
     * @return string|null
     */
    public function getFsNm()
    {
        return $this->fsNm;
    }

    /**
     * Set 개별/연결명
     *
     * @param string|null $fsNm  개별/연결명
     *
     * @return self
     */
    public function setFsNm($fsNm)
    {
        $this->fsNm = $fsNm;

        return $this;
    }

    /**
     * Get $sjDiv
     *
     * @return string|null
     */
    public function getSjDiv()
    {
        return $this->sjDiv;
    }

    /**
     * Set $sjDiv
     *
     * @param string|null $sjDiv  $sjDiv
     *
     * @return self
     */
    public function setSjDiv($sjDiv)
    {
        $this->sjDiv = $sjDiv;

        return $this;
    }

    /**
     * Get $sjNm;
     *
     * @return string|null
     */
    public function getSjNm()
    {
        return $this->sjNm;
    }

    /**
     * Set $sjNm;
     *
     * @param string|null $sjNm  $sjNm;
     *
     * @return self
     */
    public function setSjNm($sjNm)
    {
        $this->sjNm = $sjNm;

        return $this;
    }

    /**
     * Get $accountId
     *
     * @return string|null
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set $accountId
     *
     * @param string|null $accountId  $accountId
     *
     * @return self
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get $accountNm
     *
     * @return string|null
     */
    public function getAccountNm()
    {
        return $this->accountNm;
    }

    /**
     * Set $accountNm
     *
     * @param string|null $accountNm  $accountNm
     *
     * @return self
     */
    public function setAccountNm($accountNm)
    {
        $this->accountNm = $accountNm;

        return $this;
    }

    /**
     * Get $thstrmNm
     *
     * @return string|null
     */
    public function getThstrmNm()
    {
        return $this->thstrmNm;
    }

    /**
     * Set $thstrmNm
     *
     * @param string|null $thstrmNm  $thstrmNm
     *
     * @return self
     */
    public function setThstrmNm($thstrmNm)
    {
        $this->thstrmNm = $thstrmNm;

        return $this;
    }

    /**
     * Get $thstrmDt
     *
     * @return string|null
     */
    public function getThstrmDt()
    {
        return $this->thstrmDt;
    }

    /**
     * Set $thstrmDt
     *
     * @param string|null $thstrmDt  $thstrmDt
     *
     * @return self
     */
    public function setThstrmDt($thstrmDt)
    {
        $this->thstrmDt = $thstrmDt;

        return $this;
    }

    /**
     * Get $thstrmAmount
     *
     * @return string|null
     */
    public function getThstrmAmount()
    {
        return $this->thstrmAmount;
    }

    /**
     * Set $thstrmAmount
     *
     * @param string|null $thstrmAmount  $thstrmAmount
     *
     * @return self
     */
    public function setThstrmAmount($thstrmAmount)
    {
        $this->thstrmAmount = $thstrmAmount;

        return $this;
    }

    /**
     * Get $thstrmAddAmount
     *
     * @return string|null
     */
    public function getThstrmAddAmount()
    {
        return $this->thstrmAddAmount;
    }

    /**
     * Set $thstrmAddAmount
     *
     * @param string|null $thstrmAddAmount  $thstrmAddAmount
     *
     * @return self
     */
    public function setThstrmAddAmount($thstrmAddAmount)
    {
        $this->thstrmAddAmount = $thstrmAddAmount;

        return $this;
    }

    /**
     * Get $frmtrmNm
     *
     * @return string|null
     */
    public function getFrmtrmNm()
    {
        return $this->frmtrmNm;
    }

    /**
     * Set $frmtrmNm
     *
     * @param string|null $frmtrmNm  $frmtrmNm
     *
     * @return self
     */
    public function setFrmtrmNm($frmtrmNm)
    {
        $this->frmtrmNm = $frmtrmNm;

        return $this;
    }

    /**
     * Get $frmtrmAmount
     *
     * @return string|null
     */
    public function getFrmtrmAmount()
    {
        return $this->frmtrmAmount;
    }

    /**
     * Set $frmtrmAmount
     *
     * @param string|null $frmtrmAmount  $frmtrmAmount
     *
     * @return self
     */
    public function setFrmtrmAmount($frmtrmAmount)
    {
        $this->frmtrmAmount = $frmtrmAmount;

        return $this;
    }

    /**
     * Get $frmtrmAddAmount
     *
     * @return string|null
     */
    public function getFrmtrmAddAmount()
    {
        return $this->frmtrmAddAmount;
    }

    /**
     * Set $frmtrmAddAmount
     *
     * @param string|null $frmtrmAddAmount  $frmtrmAddAmount
     *
     * @return self
     */
    public function setFrmtrmAddAmount($frmtrmAddAmount)
    {
        $this->frmtrmAddAmount = $frmtrmAddAmount;

        return $this;
    }

    /**
     * Get $bfefrmtrmNm
     *
     * @return string|null
     */
    public function getBfefrmtrmNm()
    {
        return $this->bfefrmtrmNm;
    }

    /**
     * Set $bfefrmtrmNm
     *
     * @param string|null $bfefrmtrmNm  $bfefrmtrmNm
     *
     * @return self
     */
    public function setBfefrmtrmNm($bfefrmtrmNm)
    {
        $this->bfefrmtrmNm = $bfefrmtrmNm;

        return $this;
    }

    /**
     * Get $bfefrmtrmAmount
     *
     * @return string|null
     */
    public function getBfefrmtrmAmount()
    {
        return $this->bfefrmtrmAmount;
    }

    /**
     * Set $bfefrmtrmAmount
     *
     * @param string|null $bfefrmtrmAmount  $bfefrmtrmAmount
     *
     * @return self
     */
    public function setBfefrmtrmAmount($bfefrmtrmAmount)
    {
        $this->bfefrmtrmAmount = $bfefrmtrmAmount;

        return $this;
    }

    /**
     * Get $frmtrmDt
     *
     * @return string|null
     */
    public function getFrmtrmDt()
    {
        return $this->frmtrmDt;
    }

    /**
     * Set $frmtrmDt
     *
     * @param string|null $frmtrmDt  $frmtrmDt
     *
     * @return self
     */
    public function setFrmtrmDt($frmtrmDt)
    {
        $this->frmtrmDt = $frmtrmDt;

        return $this;
    }

    /**
     * Get $bfefrmtrmDt
     *
     * @return string|null
     */
    public function getBfefrmtrmDt()
    {
        return $this->bfefrmtrmDt;
    }

    /**
     * Set $bfefrmtrmDt
     *
     * @param string|null $bfefrmtrmDt  $bfefrmtrmDt
     *
     * @return self
     */
    public function setBfefrmtrmDt($bfefrmtrmDt)
    {
        $this->bfefrmtrmDt = $bfefrmtrmDt;

        return $this;
    }
}
