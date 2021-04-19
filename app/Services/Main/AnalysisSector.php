<?php

namespace App\Services\Main;

use App\Services\Service;
use Illuminate\Support\Collection;

class AnalysisSector extends Service
{

    public function __construct(Collection $sectors, $stocks)
    {
        $this->sectors = $sectors;
        $this->stocks = $stocks;
    }

    /**
     *
     *
     * @return string
     */
    public function getSectorPriority()
    {
        // 임시, 일단 전자기기로 고정
        return '013';
    }
}
