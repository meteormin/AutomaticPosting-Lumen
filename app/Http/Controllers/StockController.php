<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Http\Requets\PostStockRequests;
use App\Response\ErrorCode;
use App\Services\Libraries\ArrayParser;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Support\Facades\Storage;

class StockController extends DefaultController
{
    /**
     * open dart service
     *
     * @var OpenDartService
     */
    protected $openDart;

    public function __construct(OpenDartService $OpenDartService)
    {
        $this->openDart = $OpenDartService;
    }

    /**
     * store CorpCodes
     * Open Dart API를 통해 회사 고유코드 json으로 저장
     * @return void
     */
    public function storeCorpCodes()
    {
        $rs = $this->openDart->saveCorpCodes();

        if ($rs) {
            return $this->success($rs, 'POST');
        }

        return $this->error(ErrorCode::CONFLICT, 'failed store corp codes');
    }

    /**
     * 회사 주요계정 가져오기
     *
     * @param Request $request
     *
     * @return void
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
     * @return void
     */
    public function storeStock(Request $request)
    {
        $stocks = PostStockRequests::parse($request);

        if ($stocks->count() == 1) {
            $rs = Storage::disk('local')->put(
                "kiwoom/{$stocks->first()->get('file_name')}",
                json_encode(
                    $stocks->except('file_name')
                )
            );
        } else {
            $rs = false;

            $stocks->each(function ($item) use (&$rs) {
                $rs = Storage::disk('local')->put(
                    "kiwoom/{$item->get('file_name')}",
                    json_encode(
                        $item->except('file_name')
                    )
                );
            });
        }

        if ($rs) {
            return $this->success($rs, 'POST');
        }

        return $this->error(ErrorCode::CONFLICT, $rs);
    }
}
