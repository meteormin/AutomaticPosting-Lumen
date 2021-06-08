<?php

namespace App\Services\Main;

use App\Services\Service;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use App\Services\Kiwoom\KoaService;
use App\Data\DataTransferObjects\Finance;
use App\Data\DataTransferObjects\StockInfo;
use App\Models\Posts;
use App\Services\Kiwoom\Windows;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Support\Carbon;
use JsonMapper_Exception;

class MainService extends Service
{
    /**
     * Undocumented variable
     *
     * @var KoaService
     */
    protected KoaService $koa;

    /**
     * Undocumented variable
     *
     * @var OpenDartService
     */
    protected OpenDartService $openDart;

    /**
     * Undocumented variable
     *
     * @var Windows
     */
    protected Windows $win;

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
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getStockInfo(string $type, ?string $where = null): Collection
    {
        $stockInfo = collect();

        if ($type == 'sector') {
            if (is_null($where)) {
                $where = $this->getPriority($type);
            }

            $stockInfo = $this->koa->showBySector($where);
            if(is_null($stockInfo)) {
                $this->updateStockInfo($type, $where);
                $stockInfo = $this->koa->showBySector($where);
            }
        }

        if ($type == 'theme') {
            if (is_null($where)) {
                $where = $this->getPriority($type);
            }

            $stockInfo = $this->koa->showByTheme($where);
            if(is_null($stockInfo)) {
                $this->updateStockInfo($type, $where);
                $stockInfo = $this->koa->showByTheme($where);
            }
        }

        return $stockInfo;
    }

    /**
     * get raw data
     * @param string $type
     * @param string|null $where
     *
     * @return Collection
     * @throws JsonMapper_Exception
     * @throws FileNotFoundException
     */
    public function getRawData(string $type, ?string $where = null): Collection
    {
        $stockInfo = $this->getStockInfo($type, $where);
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
     * @throws JsonMapper_Exception|FileNotFoundException
     */
    public function getRefinedData(string $type, ?string $where = null): Collection
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
            'type' => $type,
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
    public function getPriority(string $type): string
    {
        $config = collect();

        if ($type == 'sector') {
            $config = collect(config('sectors.kospi.sectors'));
        }

        if ($type == 'theme') {
            $config = collect(config('themes.kospi.themes'));
        }

        $currentCount = Posts::where('type', $type)->count();

        // max - (max - (current % max)
        $remainder = $currentCount % $config->count();
        $index = $config->count() - ($config->count() - $remainder);

        return $config->get($index)['code'];
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
        $options = [];
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
