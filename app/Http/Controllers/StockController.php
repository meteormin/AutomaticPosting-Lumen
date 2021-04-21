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
    public function index(Request $request)
    {
        if ($request->has('sector')) {
            $dtos = $this->koa->showBySector($request->get('sector'));
        }

        $markets = collect(config('sectors'));

        $sectors = collect();

        $input = collect();

        if ($request->has('market')) {
            $input = collect($request->all());
        }

        $markets->each(function ($market) use (&$sectors, $input) {
            if ($input->has('market')) {
                if ($input->get('market') == $market) {
                    $sectors->add($market['sectors_raw']);
                }
            } else {
                $sectors->add($market['sector_raw']);
            }
        });

        foreach ($sectors->keys() as $key) {
            $dtos = $this->koa->showBySector($key);
        }

        return $this->response($dtos, 200);
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
        return $this->response($this->koa->showStock($request->get('stock_code', null)));
    }
}
