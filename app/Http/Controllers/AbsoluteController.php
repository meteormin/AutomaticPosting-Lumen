<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DefaultController;
use App\Services\Kiwoom\KoaService;
use App\Services\Main\MainService;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Http\Request;

class AbsoluteController extends DefaultController
{
    /**
     * Undocumented variable
     *
     * @var MainService
     */
    protected $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function index()
    {
        return $this->response($this->mainService->getRefinedData());
    }
}
