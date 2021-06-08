<?php


namespace App\Data\DataTransferObjects;


use App\Data\Abstracts\Dto;
use App\Data\Utils\ArrController;

class BarChartColumns extends Dto
{
    protected array $columns = [0, 1, [
        'calc' => 'stringify',
        'sourceColumn' => 1,
        'type' => 'string',
        'role' => 'annotation'
    ], 2];

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    public function toArray(bool $allowNull = false): ?array
    {
        return ArrController::camelFromArray(parent::toArray($allowNull));
    }
}
