<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DefaultController;
use App\Services\Kiwoom\KoaService;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Http\Request;

class AbsoluteController extends DefaultController
{
    protected $koa;

    protected $openDart;

    public function __construct(KoaService $koa, OpenDartService $openDart)
    {
        $this->koa = $koa;
        $this->openDart = $openDart;
    }
}
