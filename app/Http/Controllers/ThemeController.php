<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\DefaultController;
use App\Response\ErrorCode;
use App\Services\Kiwoom\KoaService;
use Illuminate\Support\Facades\Validator;

class ThemeController extends DefaultController
{
    /**
     * open dart service
     *
     * @var Collection
     */
    protected $config;

    /**
     * @var KoaService
     */
    protected KoaService $service;

    public function __construct(KoaService $service)
    {
        $this->config = collect(config('themes'));
        $this->service = $service;
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
        return $this->response($this->config->get('kospi'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $market
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $market = 'kospi')
    {
        if ($this->config->has($market)) {
            $res = $this->config->get($market);
            return $this->response($res);
        }

        return $this->error(ErrorCode::NOT_FOUND, "{$market} is not found");
    }

    public function store(Request $request, string $market = 'kospi')
    {
        $data = null;
        $validator = Validator::make($request->all(), [
            'data' => 'required|array'
        ]);

        if ($validator->fails()) {
            $this->validationFail($validator->errors());
        }

        $data = $request->get('data');

        $rs = $this->service->storeThemes($market, $data);
        return $this->success($rs, 'POST');
    }
}
