<?php

namespace App\Services\OpenDart;

use App\Models\OpenDart;
use App\Services\Service;
use App\Entities\CorpCodeEntity;

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
        $this->model = new OpenDart();
        $this->module = new OpenDartClient();
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

    public function getMultiple()
    {
    }
}
