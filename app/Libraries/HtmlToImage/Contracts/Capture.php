<?php


namespace App\Libraries\HtmlToImage\Contracts;


interface Capture
{
    const SUCCESS = 0;
    const FAIL = 1;

    public function capture();
}
