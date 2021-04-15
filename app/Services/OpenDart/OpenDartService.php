<?php

namespace App\Services\OpenDart;

use App\Models\OpenDart;
use App\Services\Service;
use App\Response\ErrorCode;
use App\Entities\AcntEntity;
use App\Entities\CorpCodeEntity;
use App\Entities\Utils\Entities;

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

    public function __construct()
    {
        $this->module = new OpenDartClient();
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
     * @return Entities
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
     *
     * @return AcntEntity
     */
    public function getSingle(int $stockCode)
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
        return $this->module->getSinglAcnt($corpCode->getCorpCode());
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
