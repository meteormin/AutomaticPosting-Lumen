<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Response\ErrorCode;
use App\Services\Libraries\ArrayParser;

class SectorController extends DefaultController
{
    /**
     * open dart service
     *
     * @var ArrayParser
     */
    protected $sectors;

    public function __construct()
    {
        $this->sectors = new ArrayParser(config('sectors'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response($this->sectors);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $market
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $market)
    {
        if ($this->sectors->has($market)) {
            return $this->response($this->sectors->get($market));
        }

        return $this->error(ErrorCode::NOT_FOUND, "{$market} is not found");
    }
}
