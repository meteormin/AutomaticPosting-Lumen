<?php

namespace App\Http\Controllers;

use App\Response\ErrorCode;
use App\Services\Kiwoom\KoaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DefaultController;

class SectorController extends DefaultController
{
    /**
     * open dart service
     *
     * @var Collection
     */
    protected Collection $config;

    /**
     * @var KoaService
     */
    protected KoaService $koa;

    public function __construct(KoaService $koa)
    {
        $this->config = collect(config('sectors'));
        $this->koa = $koa;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // 코스피 고정
        return $this->response($this->config);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $market
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $market = 'kospi'): JsonResponse
    {
        if ($this->config->has($market)) {
            $res = $this->config->get($market);
            return $this->response($res);
        }

        return $this->error(ErrorCode::NOT_FOUND, "{$market} is not found");
    }

    public function store(Request $request, string $market = 'kospi'): JsonResponse
    {
        $data = null;
        $validator = Validator::make($request->all(), [
            'data' => 'required|array'
        ]);

        if ($validator->fails()) {
            $this->validationFail($validator->errors());
        }

        $data = $request->get('data');

        $rs = $this->koa->storeSectors($market, $data);
        return $this->success($rs, 'POST');
    }
}
