<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DefaultController;
use App\Services\Main\MainService;
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

    /**
     * Undocumented function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, string $name = 'sector')
    {
        return view('post', ['data' => $this->mainService->getRefinedData($name)]);
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function raw(Request $request, string $name)
    {
        return $this->response($this->mainService->getRawData($name));
    }

    public function refine(Request $request, string $name)
    {
        return $this->response($this->mainService->getRefinedData($name));
    }
}
