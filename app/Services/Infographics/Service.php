<?php


namespace App\Services\Infographics;


use App\Data\DataTransferObjects\BarChartColumns;
use App\Data\DataTransferObjects\BarChartData;
use App\Data\DataTransferObjects\BarChartOptions;
use App\Data\DataTransferObjects\GoogleChartCollection;
use App\Data\DataTransferObjects\Refine;
use App\Data\DataTransferObjects\TreeMapChartData;
use App\Data\DataTransferObjects\TreeMapOptions;
use App\Services\Main\MainService;
use App\Services\Service as BaseService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;
use function Illuminate\Events\queueable;

class Service extends BaseService
{
    protected MainService $service;

    public function __construct(MainService $service)
    {
        $this->service = $service;
    }

    /**
     *
     * @param string $type
     * @param string $code
     * @return array
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getTreeMapChart(string $type, string $code): array
    {
        $refinedData = $this->service->getRefinedData($type, $code);

        $chartCollection = new GoogleChartCollection();
        $id = config("themes.kospi.themes_raw.{$code}");

        $chartData = TreeMapChartData::newInstance();
        $chartData->setId($id);
        $chartData->setParentId(null);
        $chartData->setSize(0);
        $chartData->setColor(0);
        $chartData->setLabels([
            'id' => '종목',
            'parentId' => $type,
            'size' => '시가총액',
            'color' => '당기순이익'
        ]);

        $chartCollection->add($chartData);
        $refinedData->get('data')->each(function (Refine $item, $key) use ($id, $type,&$chartCollection) {
            $chartData = TreeMapChartData::newInstance();
            $chartData->setId($item->getName());
            $chartData->setParentId($id);
            $chartData->setSize($item->getCapital());
            $chartData->setColor($item->getNetIncome());
            $chartData->setLabels([
                'id' => '종목',
                'parentId' => $type,
                'size' => '당기순이익',
                'color' => '적자횟수'
            ]);

            $chartCollection->add($chartData);
        });

        $response['chart'] = 'treemap';
        $response['element'] = 'treemap-chart';
        $response['data'] = $chartCollection->toDataTable();
        $response['options'] = TreeMapOptions::newInstance()->toArray();

        return $response;
    }

    /**
     * @throws JsonMapper_Exception
     * @throws FileNotFoundException
     */
    public function getBarChart(string $type, string $code): array
    {
        $refinedData = $this->service->getRefinedData($type, $code);
        $chartCollection = new GoogleChartCollection();
        $id = config("themes.kospi.themes_raw.{$code}");

        $refinedData->get('data')->each(function (Refine $item, $key) use ($id, &$chartCollection) {
            $chartData = BarChartData::newInstance();
            $chartData->setId($item->getName().' \\n 적자횟수:'.$item->getDeficitCount());
            $chartData->setValue($item->getNetIncome());
            $chartData->setRole('blue');

            $chartCollection->add($chartData);
        });

        $response['chart'] = 'bar';
        $response['element'] = 'bar-chart';
        $response['data'] = $chartCollection->toDataTable();
        $response['options'] = BarChartOptions::newInstance()->setTitle($id)->toArray();
        $response['columns'] = BarChartColumns::newInstance()->getColumns();

        return $response;
    }
}
