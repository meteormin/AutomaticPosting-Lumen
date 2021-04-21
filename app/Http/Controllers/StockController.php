<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\Kiwoom\KoaService;
use App\Http\Requests\PostStockRequest;
use App\Services\OpenDart\OpenDartService;
use App\Http\Controllers\DefaultController;
use App\Response\ErrorCode;

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
            $this->response($this->koa->showBySector($request->get('sector')));
        }

        $markets = collect(config('sectors'));

        $sectors = collect();

        $input = collect();

        if ($request->has('market')) {
            $input = collect($request->all());
        } else {
            $this->error(ErrorCode::VALIDATION_FAIL, 'market 파라미터는 필수입니다.');
        }

        $markets->each(function ($market, $name) use (&$sectors, $input) {
            if ($input->has('market')) {
                if ($input->get('market') == $name) {
                    $sectors = collect($market['sectors_raw']);
                }
            } else {
                $sectors = collect($market['sectors_raw']);
            }
        });

        $dtos = collect();
        foreach ($sectors->keys() as $key) {
            try {
                $dtos->put($key, $this->koa->showBySector($key));
            } catch (Exception $e) {
                $dtos->put($key, null);
            }
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
