<?php


namespace App\Data\DataTransferObjects;

use Illuminate\Support\Collection;

class GoogleChartCollection extends Collection
{
    /**
     * @var array
     */
    protected $items = [];

    protected array $labels = [];

    /**
     * @param bool $allowNull
     * @return array
     */
    public function toDataTable(bool $allowNull = true): array
    {
        /** @var GoogleChartData $firstData */
        $firstData = $this->first();
        if($firstData instanceof GoogleChartData){
            $this->labels = $firstData->getLabels();
        }

        $columns = [];
        $collection = $this->map(function(GoogleChartData $data) use($allowNull,&$columns){
            $arrayObject = $data->toArray($allowNull);
            $columns = array_values($this->labels);
            $data = [];
            foreach($this->labels as $key=>$value){
                $index = array_search($value, $columns);
                if(!is_null($index)) {
                    $data[(int)$index] = $arrayObject[$key];
                }
            }

            return $data;
        })->values();
        $collection->prepend($columns);

        return $collection->toArray();
    }
}
