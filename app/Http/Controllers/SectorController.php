<?php

namespace App\Http\Controllers;

use App\Response\ErrorCode;
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
    protected $config;

    public function __construct()
    {
        $this->config = collect(config('sectors'));
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
        // 코스피 고정
        return $this->response($this->config);
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

        $rs = $this->koa->storeSectors($market, $data);
        return $this->success($rs, 'POST');
    }
}
