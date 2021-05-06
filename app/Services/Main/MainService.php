<?php

namespace App\Services\Main;

use App\Services\Service;
use Illuminate\Support\Collection;
use App\Services\Kiwoom\KoaService;
use App\DataTransferObjects\Finance;
use App\DataTransferObjects\StockInfo;
use App\Models\Posts;
use App\Services\Kiwoom\Windows;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Support\Carbon;

class MainService extends Service
{
    /**
     * Undocumented variable
     *
     * @var KoaService
     */
    protected $koa;

    /**
     * Undocumented variable
     *
     * @var OpenDartService
     */
    protected $openDart;

    /**
     * Undocumented variable
     *
     * @var Windows
     */
    protected $win;

    public function __construct(KoaService $koa, OpenDartService $openDart, Windows $win)
    {
        set_time_limit(300);

        $this->koa = $koa;
        $this->openDart = $openDart;
        $this->win = $win;
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param string|null $where
     *
     * @return Collection
     */
    public function getStockInfo(string $type, string $where = null)
    {
        if ($type == 'sector') {
            if (is_null($where)) {
                $where = $this->getPriority($type);
            }

            $this->updateStockInfo($type, $where);

            $stockInfo = $this->koa->showBySector($where);
        }

        if ($type == 'theme') {
            if (is_null($where)) {
                $where = $this->getPriority($type);
            }

            $this->updateStockInfo($type, $where);

            $stockInfo = $this->koa->showByTheme($where);
        }

        return $stockInfo;
    }

    /**
     * get raw data
     * @param string $type
     * @param string|null $where
     *
     * @return Collection
     */
    public function getRawData(string $type, string $where = null)
    {
        $stockInfo = $this->getStockInfo($type, $where);
        $acnts = collect();
        $rsList = collect();
        $stockCodes = collect();

        $stockInfo->each(function ($stock) use (&$stockCodes, &$rsList) {
            if ($stock instanceof StockInfo) {
                $stockCodes->add($stock->getCode());
                $finance = new Finance;
                $finance->setStock($stock);
                $rsList->add($finance);
            }
        });

        $acnts = $this->openDart->getMultiple($stockCodes->all(), Carbon::now()->subYear()->format('Y'));

        $rsList->filter(function ($finance) use ($acnts) {
            if ($finance instanceof Finance) {
                $code = $finance->getStock()->getCode();
                $finance->setAcnt($acnts->get($code));
                return true;
            }

            return false;
        });

        return $rsList;
    }

    /**
     * Undocumented function
     * @param string $type
     * @param string|null $where
     *
     * @return Collection
     */
    public function getRefinedData(string $type, string $where = null)
    {
        $rawData = $this->getRawData($type, $where);

        $refinedData = collect();

        $rawData->each(function ($raw) use (&$refinedData) {
            if ($raw instanceof Finance) {
                if (!is_null($refine = $raw->refine())) {
                    $refinedData->add($refine);
                }
            }
        });

        return collect([
            'title' => $type,
            'code' => $where ?? $this->getPriority($type),
            'date' => Carbon::now()->subYears(3)->format('Y') . ' ~ ' . Carbon::now()->subYear()->format('Y'),
            'data' => $refinedData
        ]);
    }

    /**
     * Undocumented function
     * @param string $type
     * @return string
     */
    public function getPriority(string $type)
    {
        if ($type == 'sector') {
            $config = collect(config('sectors.kospi.sectors'));
        }

        if ($type == 'theme') {
            $config = collect(config('themes'));
        }

        $currentCount = Posts::where('type', $type)->count();

        $remainder = $config->count() % $currentCount;

        if ($remainder == 0) {
            return $config->get($remainder)['code'];
        }

        return $config->get($config->count() - $remainder)['code'];
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param string $code
     *
     * @return void
     */
    public function updateStockInfo(string $type, string $code)
    {
        if ($type == 'sector') {
            $options['market'] = 'kospi';
            $options['sector'] = $code;
        }

        if ($type == 'theme') {
            $options['theme'] = $code;
        }

        $this->win->run($type, $options);
    }
}
