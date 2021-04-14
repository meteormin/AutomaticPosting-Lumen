<?php

namespace App\Services\OpenDart;

use App\Models\OpenDart;
use App\Services\Service;
use App\Entities\CorpCodeEntity;
use App\Entities\Abstracts\Entities;

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
        $cropCodes = $this->module->getCorpCode();
        $cropCodes = $cropCodes->map(function ($item) use ($stockCode) {
            if ($item instanceof CorpCodeEntity) {
                if ($item->getStockCode() == $stockCode) {
                    return $item;
                }
            }
        });

        return $this->module->getSinglAcnt($cropCodes->first()->getCorpCode());
    }

    public function getMultiple(array $stockCodes)
    {
        foreach ($stockCodes as $stockCode) {
            $entities = (new Entities)->add($this->getSingle($stockCode));
        }

        return $entities;
    }
}
