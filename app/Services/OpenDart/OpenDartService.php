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

    public function saveCorpCodes()
    {
        return $this->module->requestCorpCodes();
    }

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

    public function getMultiple(array $stockCodes)
    {
        $entities = new Entities;

        foreach ($stockCodes as $stockCode) {
            $entities->add($this->getSingle($stockCode));
        }

        return $entities;
    }
}
