<?php

namespace App\DataTransferObjects;

use App\Entities\Utils\Entities;
use App\DataTransferObjects\Abstracts\Dto;
use App\DataTransferObjects\Abstracts\DtoInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends Dto
{
    protected $currentPage;
    protected $lastPageUrl;
    protected $prevPageUrl;
    protected $nextPageUrl;
    protected $total;

    protected $dataKey;
    protected $data;
    protected $hidden = [];

    public function __construct(LengthAwarePaginator $paginate, string $data = 'data', DtoInterface $entity)
    {
        $this->setCurrentPage($paginate->currentPage() ?? 0);
        $this->setLastPageUrl($paginate->lastPage() ?? 0);
        $this->setPrevPageUrl($paginate->previousPageUrl() ?? '');
        $this->setNextPageUrl($paginate->nextPageUrl() ?? '');
        $this->setTotal($paginate->total() ?? 0);
        $this->setData($data, $entity->mapList($paginate->items()) ?? []);
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     *
     * @param string $property
     * @param array|Arrayable|Entities $data
     *
     * @return $this
     */
    public function setData(string $property, $data = [])
    {
        $this->dataKey = $property;
        $this->data = $data;
        return $this;
    }

    /**
     * Get the value of currentPage
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */
    public function setCurrentPage($currentPage = '')
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get the value of lastPageUrl
     */
    public function getLastPageUrl()
    {
        return $this->lastPageUrl;
    }

    /**
     * Set the value of lastPageUrl
     *
     * @return  self
     */
    public function setLastPageUrl($lastPageUrl = '')
    {
        $this->lastPageUrl = $lastPageUrl;

        return $this;
    }

    /**
     * Get the value of nextPageUrl
     */
    public function getNextPageUrl()
    {
        return $this->nextPageUrl;
    }

    /**
     * Set the value of nextPageUrl
     *
     * @return  self
     */
    public function setNextPageUrl($nextPageUrl = '')
    {
        $this->nextPageUrl = $nextPageUrl;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of prevPageUrl
     */
    public function getPrevPageUrl()
    {
        return $this->prevPageUrl;
    }

    /**
     * Set the value of prevPageUrl
     *
     * @return  self
     */
    public function setPrevPageUrl($prevPageUrl = '')
    {
        $this->prevPageUrl = $prevPageUrl;

        return $this;
    }

    /**
     * 기존 Dto toArray 오버라이딩
     *
     * @param boolean $allowNull
     * @return array|null
     */
    public function toArray(bool $allowNull = false): ?array
    {
        $this->makeHidden(['hidden', 'data_key']);
        $attributes = collect(parent::toArray($allowNull));
        $data = $attributes->get('data');
        $attributes = $attributes->except(array_merge(['data'], $this->hidden));
        $attributes[$this->dataKey] = $data;

        return $attributes->all();
    }
}
