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
        $corpCodes = null;

        if ($request->has('corp_code')) {
            $corpCodes = explode(',', $request->get('corp_code'));
        }

        return $this->openDart->getCorpCode($corpCodes);
    }

    /**
     * 회사 주요계정 가져오기
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $entities = $this->openDart->getMultiple(['005930']);

        return $this->response($entities, 200);
    }

    /**
     * store stock info
     * 키움 API에서 보내준 주가정보 저장
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeStock(Request $request)
    {
        $stocks = PostStockRequest::parse($request);
        $rs = $this->koa->storeStock($stocks);

        return $this->success($rs, 'POST');
    }

    public function showStock(Request $request)
    {
        $stockCodes = null;
        if ($request->has('stock_code')) {
            $stockCodes = explode(',', $request->get('stock_code'));
        }
        return $this->koa->showStock($stockCodes);
    }
}
