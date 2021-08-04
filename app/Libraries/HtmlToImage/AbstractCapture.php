<?php


namespace App\Libraries\HtmlToImage;


use App\Libraries\HtmlToImage\Contracts\HtmlToImage;

abstract class AbstractCapture implements Contracts\Capture
{
    protected HtmlToImage $htmlToImage;

    public function __construct(HtmlToImage $htmlToImage)
    {
        $this->htmlToImage = $htmlToImage;
    }

    abstract public function capture();
}
