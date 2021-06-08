<?php


namespace App\Data\DataTransferObjects;


class TreeMapOptions extends Options
{
    protected string $minColor = '#f00';
    protected string $midColor = '#ddd';
    protected string $maxColor = '#0d0';
    protected int $headerHeight = 15;
    protected ?string $fontColor = 'black';
    protected bool $showScale = true;

    /**
     * @return string
     */
    public function getMinColor(): string
    {
        return $this->minColor;
    }

    /**
     * @param string $minColor
     */
    public function setMinColor(string $minColor): void
    {
        $this->minColor = $minColor;
    }

    /**
     * @return string
     */
    public function getMidColor(): string
    {
        return $this->midColor;
    }

    /**
     * @param string $midColor
     */
    public function setMidColor(string $midColor): void
    {
        $this->midColor = $midColor;
    }

    /**
     * @return string
     */
    public function getMaxColor(): string
    {
        return $this->maxColor;
    }

    /**
     * @param string $maxColor
     */
    public function setMaxColor(string $maxColor): void
    {
        $this->maxColor = $maxColor;
    }

    /**
     * @return int
     */
    public function getHeaderHeight(): int
    {
        return $this->headerHeight;
    }

    /**
     * @param int $headerHeight
     */
    public function setHeaderHeight(int $headerHeight): void
    {
        $this->headerHeight = $headerHeight;
    }

    /**
     * @return string|null
     */
    public function getFontColor(): ?string
    {
        return $this->fontColor;
    }

    /**
     * @param string|null $fontColor
     */
    public function setFontColor(?string $fontColor): void
    {
        $this->fontColor = $fontColor;
    }

    /**
     * @return bool
     */
    public function isShowScale(): bool
    {
        return $this->showScale;
    }

    /**
     * @param bool $showScale
     */
    public function setShowScale(bool $showScale): void
    {
        $this->showScale = $showScale;
    }

}
