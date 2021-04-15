<?php

namespace App\Http\Requets;

use Throwable;
use App\Entities\StockInfo;
use App\Response\ErrorCode;
use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * request에 대한 처리
 */
class PostStockRequests
{
    /**
     * parse
     *
     * @param Request $request
     *
     * @return Collection
     */
    public static function parse(Request $request)
    {
        $jsonArray = collect();

        try {
            if ($request->has('sectors')) {
                $sectors = collect($request->get('sectors'));

                $sectors->each(function ($item) use (&$jsonArray) {
                    $jsonArray->add(self::convert($item));
                });
            } else {
                $jsonArray->add(self::convert($request->all()));
            }
        } catch (Throwable $e) {
            self::failedValidation("Failed Parse Request: {$e->getMessage()}");
        }

        if ($jsonArray->isEmpty()) {
            self::failedValidation('Failed Parse Request: not found data');
        }

        return $jsonArray;
    }

    /**
     * convert
     *
     * @param array $req
     *
     * @return Collection
     */
    protected static function convert(array $req)
    {
        $req = collect($req);
        $stockInfo = new StockInfo;
        return collect([
            'file_name' => "sector_{$req->get('code')}",
            'sector_code' => $req->get('code'),
            'sector_name' => $req->get('name'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
            'stock_data' => $stockInfo->mapList($req->get('data'))
        ]);
    }

    /**
     * throw Exception
     *
     * @param array|string $error
     *
     * @throws HttpResponseException
     */
    protected static function failedValidation($error)
    {
        throw new HttpResponseException(ApiResponse::error(ErrorCode::VALIDATION_FAIL, $error));
    }
}
