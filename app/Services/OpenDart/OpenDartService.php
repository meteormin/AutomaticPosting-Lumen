<?php

namespace App\Services\OpenDart;

use App\Models\OpenDart;
use App\Services\Service;
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
        return $this->module->requestCorpCodes();
    }

    /**
     * 단일 회사 주요 계정가져오기
     *
     * @param integer $stockCode
     *
     * @return void
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

        return $this->module->getSinglAcnt($corpCodes->first()->getCorpCode());
    }

    /**
     * 다중 회사 주요 계정 가져오기
     *
     * @param array $stockCodes
     *
     * @return void
     */
    public function getMultiple(array $stockCodes)
    {
        $entities = new Entities;

        foreach ($stockCodes as $stockCode) {
            $entities->add($this->getSingle($stockCode));
        }

        return $entities;
    }
}
