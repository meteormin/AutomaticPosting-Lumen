<?php

namespace App\Data\DataTransferObjects;

use Illuminate\Support\Collection;
use App\Data\Abstracts\Dto;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Data\Abstracts\DtoInterface;
use JsonMapper_Exception;

class Paginator extends Dto
{
    /**
     * @var int
     */
    protected int $currentPage;

    /**
     * @var string
     */
    protected ?string $lastPageUrl;

    /**
     * @var string|null
     */
    protected ?string $prevPageUrl;

    /**
     * @var string|null
     */
    protected ?string $nextPageUrl;

    /**
     * @var int
     */
    protected int $total;

    /**
     * @var string
     */
    protected string $dataKey;

    /**
     * @var array|Collection
     */
    protected $data;

    /**
     * Paginator constructor.
     * @param LengthAwarePaginator $paginate
     * @param string $data
     * @param DtoInterface $mapInstance
     * @throws JsonMapper_Exception
     */
    public function __construct(LengthAwarePaginator $paginate, DtoInterface $mapInstance, string $data = 'data')
    {
        parent::__construct();
        $this->setCurrentPage($paginate->currentPage());
        $this->setLastPageUrl($paginate->lastPage());
        $this->setPrevPageUrl($paginate->previousPageUrl());
        $this->setNextPageUrl($paginate->nextPageUrl());
        $this->setTotal($paginate->total());
        $this->setData($data, $mapInstance->mapList($paginate->items()));
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
     * @param array|Arrayable|Collection $data
     *
     * @return $this
     */
    public function setData(string $property, $data = []): Paginator
    {
        $this->dataKey = $property;
        $this->data = $data;
        return $this;
    }

    /**
     * Get the value of currentPage
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */
    public function setCurrentPage($currentPage = ''): Paginator
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get the value of lastPageUrl
     */
    public function getLastPageUrl(): ?string
    {
        return $this->lastPageUrl;
    }

    /**
     * Set the value of lastPageUrl
     *
     * @return $this
     */
    public function setLastPageUrl($lastPageUrl = ''): Paginator
    {
        $this->lastPageUrl = $lastPageUrl;

        return $this;
    }

    /**
     * Get the value of nextPageUrl
     */
    public function getNextPageUrl(): ?string
    {
        return $this->nextPageUrl;
    }

    /**
     * @param string $nextPageUrl
     * @return $this
     */
    public function setNextPageUrl($nextPageUrl = ''): Paginator
    {
        $this->nextPageUrl = $nextPageUrl;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  $this
     */
    public function setTotal($total): Paginator
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of prevPageUrl
     */
    public function getPrevPageUrl(): ?string
    {
        return $this->prevPageUrl;
    }

    /**
     * Set the value of prevPageUrl
     *
     * @return  $this
     */
    public function setPrevPageUrl($prevPageUrl = ''): Paginator
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
    public function toArray(bool $allowNull = true): ?array
    {
        $this->makeHidden(['hidden', 'data_key']);
        $attributes = collect(parent::toArray($allowNull));
        $data = $attributes->get('data');
        $attributes = $attributes->except(array_merge(['data'], $this->hidden));
        $attributes[$this->dataKey] = $data;

        return $attributes->all();
    }
}
