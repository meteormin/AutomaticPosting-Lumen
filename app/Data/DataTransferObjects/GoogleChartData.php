<?php


namespace App\Data\DataTransferObjects;


use App\Data\Abstracts\Dto;
use App\Data\Utils\ArrController;

abstract class GoogleChartData extends Dto
{
    protected array $labels = [];

    public function toArray(bool $allowNull = false): ?array
    {
        $this->makeHidden('labels');
        return ArrController::camelFromArray(parent::toArray($allowNull));
    }

    /**
     * @param array $labels
     * @return $this
     */
    public function setLabels(array $labels): GoogleChartData
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
