<?php

namespace App\Services\OpenDart;

use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;
use App\DataTransferObjects\CorpCode;
use App\DataTransferObjects\AcntEntity;
use App\DataTransferObjects\Utils\Dtos;

class OpenDartService extends Service
{
    /**
     * @var OpenDartClient
     */
    protected $module;

    public function __construct(OpenDartClient $client)
    {
        $this->module = $client;
    }

    /**
     * 회사 고유코드 저장
     *
     * @return Acnt
     */
    public function saveCorpCodes()
    {
        if ($this->module->requestCorpCodes()) {
            return true;
        }

        $this->throw(ErrorCode::CONFLICT, 'failed store corp codes');
    }

    /**
     * Undocumented function
     *
     * @param string $code
     *
     * @return Dtos|Collection|Paginator
     */
    public function getCorpCode(string $code = null)
    {
        if (is_null($code)) {
            return $this->module->getCorpCode();
        }

        $codes = explode(',', $code);
        $res = new Dtos;
        foreach ($codes as $code) {
            $res->add($this->module->getCorpCode($code)->first());
        }

        return $res;
    }

    /**
     * 단일 회사 주요 계정가져오기
     *
     * @param integer $stockCode
     * @param string|null $year
     *
     * @return Dtos|Acnt[]
     */
    public function getSingle(string $stockCode, string $year = null)
    {
        $corpCodes = $this->module->getCorpCode();

        $corpCodes = $corpCodes->filter(function ($item) use ($stockCode) {
            if ($item instanceof CorpCode) {
                return $item->getStockCode() == $stockCode;
            }
            return false;
        });

        $corpCode = $corpCodes->first();
        if (is_null($corpCode)) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, "can not found sotck: " . $stockCode);
        }

        if (is_null($year)) {
            $year = Carbon::now()->format('Y');
        }

        if (!is_numeric($year) || strlen($year) != 4) {
            $this->throw(ErrorCode::VALIDATION_FAIL, "year parameter must be 'yyyy' format");
        }

        return $this->module->getSinglAcnt($corpCode->getCorpCode(), $year);
    }

    /**
     * 다중 회사 주요 계정 가져오기
     *
     * @param array $stockCodes
     *
     * @return Dtos
     */
    public function getMultiple(array $stockCodes)
    {
        $dtos = new Dtos;

        foreach ($stockCodes as $stockCode) {
            $dtos->add($this->getSingle($stockCode));
        }

        if ($dtos->isEmpty()) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, "can not found storcks");
        }

        return $dtos;
    }
}
