<?php

namespace App\Services\Main;

use App\Services\Service;
use Illuminate\Support\Collection;
use App\Services\Kiwoom\KoaService;
use App\DataTransferObjects\Finance;
use App\DataTransferObjects\PostsStatus as PostsStatusDto;
use App\DataTransferObjects\Posts as PostsDto;
use App\DataTransferObjects\StockInfo;
use App\Models\Posts;
use App\Models\PostsStatus;
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
     * @param string $name
     * @param string|null $where
     *
     * @return Collection
     */
    protected function getStockInfo(string $name, string $where = null)
    {
        if ($name == 'sector') {
            if (is_null($where)) {
                $where = $this->getPriority($name);
            }

            $this->win->run($name, ['market' => 'kospi', 'sector' => $where]);

            $stockInfo = $this->koa->showBySector($where);
        }

        if ($name == 'theme') {
            if (is_null($where)) {
                $where = $this->getPriority($name);
            }

            $this->win->run($name, ['theme' => $where]);

            $stockInfo = $this->koa->showByTheme($where);
        }

        return $stockInfo;
    }

    /**
     * get raw data
     * @param string $name
     * @param string|null $where
     *
     * @return Collection
     */
    public function getRawData(string $name, string $where = null)
    {
        $stockInfo = $this->getStockInfo($name, $where);
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
     * @param string $name
     * @param string|null $where
     *
     * @return Collection
     */
    public function getRefinedData(string $name, string $where = null)
    {
        $rawData = $this->getRawData($name, $where);

        $refinedData = collect();

        $rawData->each(function ($raw) use (&$refinedData) {
            if ($raw instanceof Finance) {
                if (!is_null($refine = $raw->refine())) {
                    $refinedData->add($refine);
                }
            }
        });

        return collect([
            'title' => $name,
            'code' => $where ?? $this->getPriority($name),
            'date' => Carbon::now()->subYears(3)->format('Y') . ' ~ ' . Carbon::now()->subYear()->format('Y'),
            'data' => $refinedData
        ]);
    }

    /**
     * Undocumented function
     * @param string $name
     * @return string
     */
    protected function getPriority(string $name)
    {
        if ($name == 'sector') {
            $config = collect(config('sectors.kospi.sectors'));
        }

        if ($name == 'theme') {
            $config = collect(config('themes'));
        }

        $currentCount = Posts::where('type', $name)->count();

        $remainder = $config->count() % $currentCount;

        if ($remainder == 0) {
            return $config->get($remainder)['code'];
        }

        return $config->get($config->count() - $remainder)['code'];
    }
}
