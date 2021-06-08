<?php


namespace App\Data\DataTransferObjects;


use App\Data\Abstracts\Dto;
use App\Data\Utils\ArrController;

abstract class Options extends Dto
{
    protected string $width = '100%';
    protected string $height = 'auto';
    protected ?string $title = null;

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @param string $width
     * @return Options
     */
    public function setWidth(string $width): Options
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     * @return Options
     */
    public function setHeight(string $height): Options
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Options
     */
    public function setTitle(?string $title): Options
    {
        $this->title = $title;
        return $this;
    }

    public function  toArray(bool $allowNull = false): ?array
    {
        return ArrController::camelFromArray(parent::toArray($allowNull));
    }
}
