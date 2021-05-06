<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\DefaultController;

class SectorController extends DefaultController
{
    /**
     * open dart service
     *
     * @var Collection
     */
    protected $sectors;

    public function __construct()
    {
        $this->sectors = collect(config('sectors'));
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
            $res = $this->sectors->get($market);
            return $this->response($res);
        }

        return $this->error(self::NOT_FOUND, "{$market} is not found");
    }
}
