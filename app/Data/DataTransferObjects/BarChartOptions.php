<?php


namespace App\Data\DataTransferObjects;


class BarChartOptions extends Options
{
    protected array $bar = [
        'groupWidth' => '95%'
    ];

    protected array $legend = [
        'position'=> 'none'
    ];

    /**
     * @return array|string[]
     */
    public function getBar(): array
    {
        return $this->bar;
    }

    /**
     * @param array|string[] $bar
     */
    public function setBar(array $bar): void
    {
        $this->bar = $bar;
    }

    /**
     * @return array|string[]
     */
    public function getLegend(): array
    {
        return $this->legend;
    }

    /**
     * @param array|string[] $legend
     */
    public function setLegend(array $legend): void
    {
        $this->legend = $legend;
    }

}
