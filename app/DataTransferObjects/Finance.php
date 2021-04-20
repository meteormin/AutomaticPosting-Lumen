<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Utils\Dtos;
use App\DataTransferObjects\Abstracts\Dto;

class Finance extends Dto
{
    /**
     * @var StockInfo|null $stock
     */
    protected $stock;

    /**
     * @var Dtos|null $acnt
     */
    protected $acnt;

    /**
     * 재무정보 filter 조건
     *
     * @var array
     */
    protected static $filters = [
        'account_nm' => [
            '유동자산',
            '유동부채',
            '당기순이익'
        ],
        'fs_div' => [
            'CFS'
        ]
    ];

    /**
     * construct
     *
     * @param StockInfo|null $stock
     * @param Dtos|null $acnt
     */
    public function __construct(?StockInfo $stock = null, ?Dtos $acnt = null)
    {
        $this->stock = $stock;
        $this->acnt = $acnt;
    }

    /**
     * set stock info
     *
     * @param StockInfo|null $stock
     *
     * @return $this
     */
    public function setStock(?StockInfo $stock)
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * get stock info
     *
     * @return StockInfo|null
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * set acnt list
     *
     * @param Dtos|Acnt[]|null $acnt
     *
     * @return $this
     */
    public function setAcnt($acnt)
    {
        $this->acnt = new Dtos($acnt);
        return $this;
    }

    /**
     * get acnt list
     *
     * @return Dtos|Acnt[]
     */
    public function getAcnt()
    {
        return $this->acnt;
    }

    /**
     * Undocumented function
     *
     * @param array $filter
     *
     * @return void
     */
    public static function setFilterAttributeInAcnt(array $filters)
    {
        self::$filters = $filters;
    }

    /**
     * 필터 조건
     * 1차원 요소 AND 조건
     * 2차원 요소 OR 조건
     *
     * @return array
     */
    protected static function getFilterAttributeInAcnt(): array
    {
        return self::$filters;
    }

    public function toArray(bool $allowNull = true): ?array
    {
        $where = $this->getFilterAttributeInAcnt();

        $acnt = collect($this->getAcnt()->toArray());
        foreach ($where as $attr => $value) {
            $acnt = $acnt->whereIn($attr, $value);
        }

        $rsList = collect($this->getStock()->toArray());
        $rsList->put('finance_data', $acnt);

        return $rsList->toArray();
    }
}
