<?php

namespace App\Services\OpenDart;

use App\Services\Service;
use App\Response\ErrorCode;
use App\Entities\AcntEntity;
use Illuminate\Support\Carbon;
use App\Entities\CorpCodeEntity;
use App\Entities\Utils\Entities;
use Illuminate\Pagination\Paginator;

class OpenDartService extends Service
{
    /**
     * @var Model
     */
    protected $model;

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
     * @return AcntEntity
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
     * @return Entities|Collection|Paginator
     */
    public function getCorpCode(string $code = null)
    {
        if (is_null($code)) {
            return $this->module->getCorpCode();
        }

        $codes = explode(',', $code);
        $res = new Entities;
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
     * @return AcntEntity
     */
    public function getSingle(int $stockCode, string $year = null)
    {
        $corpCodes = $this->module->getCorpCode();

        $corpCodes = $corpCodes->filter(function ($item) use ($stockCode) {
            if ($item instanceof CorpCodeEntity) {
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
     * @return Entities
     */
    public function getMultiple(array $stockCodes)
    {
        $entities = new Entities;

        foreach ($stockCodes as $stockCode) {
            $entities->add($this->getSingle($stockCode));
        }

        if ($entities->isEmpty()) {
            $this->throw(ErrorCode::RESOURCE_NOT_FOUND, "can not found storcks");
        }

        return $entities;
    }
}
