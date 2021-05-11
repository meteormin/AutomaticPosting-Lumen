<?php

namespace App\Data\DataTransferObjects;

use App\Data\Abstracts\Dto;

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
    public function getOrd(): ?int
    {
        return $this->ord;
    }

    /**
     * Set $ord
     *
     * @param int|null $ord  $ord
     *
     * @return Acnt
     */
    public function setOrd(?int $ord): Acnt
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get $rceptNo
     *
     * @return string|null
     */
    public function getRceptNo(): ?string
    {
        return $this->rceptNo;
    }

    /**
     * Set $rceptNo
     *
     * @param string|null $rceptNo  $rceptNo
     *
     * @return Acnt
     */
    public function setRceptNo(?string $rceptNo): Acnt
    {
        $this->rceptNo = $rceptNo;

        return $this;
    }

    /**
     * Get $reptCode
     *
     * @return string|null
     */
    public function getReptCode(): ?string
    {
        return $this->reptCode;
    }

    /**
     * Set $reptCode
     *
     * @param string|null $reptCode  $reptCode
     *
     * @return Acnt
     */
    public function setReptCode(?string $reptCode): Acnt
    {
        $this->reptCode = $reptCode;

        return $this;
    }

    /**
     * Get $bsnsYear
     *
     * @return string|null
     */
    public function getBsnsYear(): ?string
    {
        return $this->bsnsYear;
    }

    /**
     * Set $bsnsYear
     *
     * @param string|null $bsnsYear  $bsnsYear
     *
     * @return Acnt
     */
    public function setBsnsYear(?string $bsnsYear): Acnt
    {
        $this->bsnsYear = $bsnsYear;

        return $this;
    }

    /**
     * Get $corpCode
     *
     * @return string|null
     */
    public function getCorpCode(): ?string
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
    public function setCorpCode(?string $corpCode): Acnt
    {
        $this->corpCode = $corpCode;

        return $this;
    }

    /**
     * Get $stockCode;
     *
     * @return string|null
     */
    public function getStockCode(): ?string
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
    public function setStockCode(?string $stockCode): Acnt
    {
        $this->stockCode = $stockCode;

        return $this;
    }

    /**
     * Get 개별/연결구분
     *
     * @return string|null
     */
    public function getFsDiv(): ?string
    {
        return $this->fsDiv;
    }

    /**
     * Set 개별/연결구분
     *
     * @param string|null $fsDiv  개별/연결구분
     *
     * @return Acnt
     */
    public function setFsDiv(?string $fsDiv): Acnt
    {
        $this->fsDiv = $fsDiv;

        return $this;
    }

    /**
     * Get 개별/연결명
     *
     * @return string|null
     */
    public function getFsNm(): ?string
    {
        return $this->fsNm;
    }

    /**
     * Set 개별/연결명
     *
     * @param string|null $fsNm  개별/연결명
     *
     * @return Acnt
     */
    public function setFsNm(?string $fsNm): Acnt
    {
        $this->fsNm = $fsNm;

        return $this;
    }

    /**
     * Get $sjDiv
     *
     * @return string|null
     */
    public function getSjDiv(): ?string
    {
        return $this->sjDiv;
    }

    /**
     * Set $sjDiv
     *
     * @param string|null $sjDiv  $sjDiv
     *
     * @return Acnt
     */
    public function setSjDiv(?string $sjDiv): Acnt
    {
        $this->sjDiv = $sjDiv;

        return $this;
    }

    /**
     * Get $sjNm;
     *
     * @return string|null
     */
    public function getSjNm(): ?string
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
    public function setSjNm(?string $sjNm): Acnt
    {
        $this->sjNm = $sjNm;

        return $this;
    }

    /**
     * Get $accountId
     *
     * @return string|null
     */
    public function getAccountId(): ?string
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
    public function setAccountId(?string $accountId): Acnt
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get $accountNm
     *
     * @return string|null
     */
    public function getAccountNm(): ?string
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
    public function setAccountNm(?string $accountNm): Acnt
    {
        $this->accountNm = $accountNm;

        return $this;
    }

    /**
     * Get $thstrmNm
     *
     * @return string|null
     */
    public function getThstrmNm(): ?string
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
    public function setThstrmNm(?string $thstrmNm): Acnt
    {
        $this->thstrmNm = $thstrmNm;

        return $this;
    }

    /**
     * Get $thstrmDt
     *
     * @return string|null
     */
    public function getThstrmDt(): ?string
    {
        return $this->thstrmDt;
    }

    /**
     * @param string|null $thstrmDt
     * @return $this
     */
    public function setThstrmDt(?string $thstrmDt): Acnt
    {
        $this->thstrmDt = $thstrmDt;

        return $this;
    }

    /**
     * Get $thstrmAmount
     *
     * @return string|null
     */
    public function getThstrmAmount(): ?string
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
    public function setThstrmAmount(?string $thstrmAmount): Acnt
    {
        $this->thstrmAmount = $thstrmAmount;

        return $this;
    }

    /**
     * Get $thstrmAddAmount
     *
     * @return string|null
     */
    public function getThstrmAddAmount(): ?string
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
    public function setThstrmAddAmount(?string $thstrmAddAmount): Acnt
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
    public function setFrmtrmNm(?string $frmtrmNm): Acnt
    {
        $this->frmtrmNm = $frmtrmNm;

        return $this;
    }

    /**
     * Get $frmtrmAmount
     *
     * @return string|null
     */
    public function getFrmtrmAmount(): Acnt
    {
        return $this->frmtrmAmount;
    }

    /**
     * Set $frmtrmAmount
     *
     * @param string|null $frmtrmAmount
     *
     * @return self
     */
    public function setFrmtrmAmount(?string $frmtrmAmount)
    {
        $this->frmtrmAmount = $frmtrmAmount;

        return $this;
    }

    /**
     * Get $frmtrmAddAmount
     *
     * @return string|null
     */
    public function getFrmtrmAddAmount(): ?string
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
    public function setFrmtrmAddAmount(?string $frmtrmAddAmount): Acnt
    {
        $this->frmtrmAddAmount = $frmtrmAddAmount;

        return $this;
    }

    /**
     * Get $bfefrmtrmNm
     *
     * @return string|null
     */
    public function getBfefrmtrmNm(): ?string
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
    public function setBfefrmtrmNm(?string $bfefrmtrmNm): Acnt
    {
        $this->bfefrmtrmNm = $bfefrmtrmNm;

        return $this;
    }

    /**
     * Get $bfefrmtrmAmount
     *
     * @return string|null
     */
    public function getBfefrmtrmAmount(): ?string
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
    public function setBfefrmtrmAmount(?string $bfefrmtrmAmount): Acnt
    {
        $this->bfefrmtrmAmount = $bfefrmtrmAmount;

        return $this;
    }

    /**
     * Get $frmtrmDt
     *
     * @return string|null
     */
    public function getFrmtrmDt(): ?string
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
    public function setFrmtrmDt(?string $frmtrmDt): Acnt
    {
        $this->frmtrmDt = $frmtrmDt;

        return $this;
    }

    /**
     * Get $bfefrmtrmDt
     *
     * @return string|null
     */
    public function getBfefrmtrmDt(): ?string
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
    public function setBfefrmtrmDt(?string $bfefrmtrmDt): Acnt
    {
        $this->bfefrmtrmDt = $bfefrmtrmDt;

        return $this;
    }

    /**
     * @param bool $allowNull
     * @return array|null
     */
    public function toArray(bool $allowNull = true): ?array
    {
        return parent::toArray($allowNull);
    }
}
