<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;

class RefinedData extends StockInfo
{
    protected $financeData;

    protected $hidden = [];

    protected $attributes = ['current_assets', 'floating_debt', 'net_income'];
}
