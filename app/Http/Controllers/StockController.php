<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Kiwoom\KoaService;
use App\Http\Requests\PostStockRequest;
use App\Services\OpenDart\OpenDartService;
use App\Http\Controllers\DefaultController;

class StockController extends DefaultController
{
    /**
     * open dart service
     *
     * @var OpenDartService
     */
    protected $openDart;

    /**
     * koa service
     *
     * @var KoaService
     */
    protected $koa;

    public function __construct(OpenDartService $OpenDartService, KoaService $koa)
    {
        $this->openDart = $OpenDartService;
        $this->koa = $koa;
    }

    /**
     * store CorpCodes
     * Open Dart API를 통해 회사 고유코드 json으로 저장
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCorpCodes()
    {
        $rs = $this->openDart->saveCorpCodes();

        return $this->success($rs, 'POST');
    }

    public function showCorpCode(Request $request)
    {
        return $this->response($this->openDart->getCorpCode($request->get('corp_code', null)));
    }

    /**
     * get stock info
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sectors(Request $request)
    {
        if ($request->has('sector')) {
            return $this->response($this->koa->showBySector($request->get('sector')));
        }

        return $this->response($this->koa->showStock('sector'));
    }

    /**
     * get stock info
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function themes(Request $request)
    {
        if ($request->has('theme')) {
            return $this->response($this->koa->showByTheme($request->get('theme')));
        }

        return $this->response($this->koa->showStock('theme'));
    }

    /**
     * store stock info
     * 키움 API에서 보내준 주가정보 저장
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeStock(Request $request, string $method)
    {
        $stocks = PostStockRequest::parse($method, $request);
        $rs = $this->koa->storeStock($method, $stocks);

        return $this->success($rs, 'POST');
    }

    public function storeThemes(Request $request)
    {
        $data = null;
        if ($request->has('data')) {
            $data = $request->get('data');
        }

        $rs = $this->koa->storeThemes($data);
        return $this->success($rs);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string|null $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showStockBySector(Request $request, string $code = null)
    {
        $codes = null;
        if ($request->has('stock_code')) {
            $codes = explode(',', $request->get('stock_code'));
        }

        return $this->response($this->koa->showStock('sector', $codes ?? [$code]));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string|null $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showStockByTheme(Request $request, string $code = null)
    {
        $codes = null;
        if ($request->has('stock_code')) {
            $codes = explode(',', $request->get('stock_code'));
        }

        return $this->response($this->koa->showStock('theme', $codes ?? [$code]));
    }
}
