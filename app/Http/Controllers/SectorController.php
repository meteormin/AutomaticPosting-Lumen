<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Response\ErrorCode;
use App\Services\Libraries\ArrayParser;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Support\Facades\Storage;

class Sectorontroller extends DefaultController
{
    /**
     * open dart service
     *
     * @var ArrayParser
     */
    protected $sectors;

    public function __construct(OpenDartService $OpenDartService)
    {
        $this->sectors = new ArrayParser(config('sectors'));
    }

    public function index(Request $request)
    {
        return $this->response($this->sectors, 200);
    }

    public function show(Request $request, string $market)
    {
        if ($this->sectors->has($market)) {
            return $this->response($this->sectors->get($market), 200);
        }

        return $this->error(ErrorCode::NOT_FOUND, "{$market} is not found");
    }
}
