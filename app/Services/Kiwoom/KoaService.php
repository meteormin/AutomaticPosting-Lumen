<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class KoaService extends Service
{
    public function __construct()
    {
    }

    /**
     * Undocumented function
     *
     * @param Collection $stocks
     *
     * @return bool
     */
    public function storeStock(Collection $stocks)
    {
        $rs = [];

        if ($stocks->count() == 1) {
            $stock = $stocks->first();
            $rs[] = [
                'sector_code' => $stock->get('stock_code'),
                'sector_name' => $stock->get('stock_name'),
                'result' => Storage::disk('local')->put(
                    "kiwoom/{$stock->get('file_name')}",
                    $stock->except('file_name')->toJson(JSON_UNESCAPED_UNICODE)
                )
            ];

            if (!$rs) {
                $this->throw(ErrorCode::CONFLICT, '섹터 별 주가정보 저장 실패,' . $stocks->get('stock_code'));
            }
        } else {
            $stocks->each(function ($item) use (&$rs) {
                $rs[] = [
                    'sector_code' => $item->get('stock_code'),
                    'sector_name' => $item->get('stock_name'),
                    'result' => Storage::disk('local')->put(
                        "kiwoom/{$item->get('file_name')}",
                        $item->except('file_name')->toJson(JSON_UNESCAPED_UNICODE)
                    )
                ];
            });

            if (count($rs) == 0) {
                $this->throw(ErrorCode::CONFLICT, '섹터 별 주가정보 저장 실패, ' . $stocks->get('stock_code'));
            }
        }

        return $rs;
    }
}
