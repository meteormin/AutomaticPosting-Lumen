<?php


namespace App\Data\DataTransferObjects;


class BarChartData extends GoogleChartData
{
    protected string $id;
    protected string $value;
    protected string $role = '';
    protected array $labels = [];

    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->setLabels([
            'id' => 'Element',
            'value' => 'Density',
            'role' => ['role' => 'style']
        ]);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return BarChartData
     */
    public function setId(string $id): BarChartData
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return BarChartData
     */
    public function setValue(string $value): BarChartData
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return BarChartData
     */
    public function setRole(string $role): BarChartData
    {
        $this->role = $role;
        return $this;
    }

}
