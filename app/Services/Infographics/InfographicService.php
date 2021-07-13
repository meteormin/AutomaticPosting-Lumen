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
use Illuminate\Support\Collection;
use JsonMapper_Exception;

class InfographicService extends BaseService
{
    protected MainService $service;

    /**
     * @var array
     */
    protected array $config;

    public function __construct(MainService $service)
    {
        $this->service = $service;
        $this->config['theme'] = config('themes.kospi.themes_raw');
        $this->config['sector'] = config('sectors.kospi.sectors_raw');
    }

    /**
     * @param string $type
     * @param string $code
     * @return Collection
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    protected function getRefinedDataByCode(string $type, string $code): Collection
    {
        $refinedData = $this->service->getRefinedData($type, $code);

        if (is_null($refinedData)) {
            return collect();
        }

        return collect([
            $code => $refinedData->get('data')
        ]);
    }

    /**
     * @param string $type
     * @return Collection
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    protected function getRefinedDataByType(string $type): Collection
    {
        $codes = $this->config[$type];
        $rsList = collect();
        foreach ($codes as $code) {
            $refinedData = $this->service->getRefinedData($type, $code);
            if (!is_null($refinedData)) {
                $rsList->put($code, $refinedData->get('data'));
            }
        }

        return $rsList;
    }

    /**
     *
     * @param string $type
     * @param string|null $code
     * @return array
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getTreeMapChart(string $type, string $code = null): array
    {
        $chartData = TreeMapChartData::newInstance();
        $chartData->setParentId(null);
        $chartData->setSize(0);
        $chartData->setColor(0);
        $chartData->setLabels([
            'id' => '종목',
            'parentId' => $type,
            'size' => '시가총액',
            'color' => '당기순이익'
        ]);

        if (is_null($code)) {
            $chartData->setId('');
            $refinedData = $this->getRefinedDataByType($type);
        } else {
            $id = $this->config[$type][$code];
            $chartData->setId($id);
            $refinedData = $this->getRefinedDataByCode($type, $code);
        }

        if($refinedData->isEmpty()){
            return [];
        }

        $chartCollection = new GoogleChartCollection();
        $chartCollection->add($chartData);

        foreach ($refinedData as $collection) {
            $collection->each(function (Refine $item, $key) use ($id, $type, &$chartCollection) {
                $chartData = TreeMapChartData::newInstance();
                $chartData->setId($item->getName() . " (적자횟수: {$item->getDeficitCount()})");
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
        }

        $response['chart'] = 'treemap';
        $response['element'] = 'treemap-chart';
        $response['data'] = $chartCollection->toDataTable();
        $response['options'] = TreeMapOptions::newInstance()->toArray();

        return $response;
    }

    /**
     * @param string $type
     * @param string|null $code
     * @return array
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getBarChart(string $type, string $code = null): array
    {
        $chartCollection = new GoogleChartCollection();

        if (is_null($code)) {
            $id = $type;
            $refinedData = $this->getRefinedDataByType($type);
        } else {
            $id = $this->config[$type][$code];
            $refinedData = $this->getRefinedDataByCode($type, $code);
        }
        foreach ($refinedData as $collection) {
            $collection->each(function (Refine $item, $key) use ($id, &$chartCollection) {
                $chartData = BarChartData::newInstance();
                $chartData->setId($item->getName() . " (적자횟수: {$item->getDeficitCount()})");
                $chartData->setValue($item->getNetIncome());
                $chartData->setRole('blue');

                $chartCollection->add($chartData);
            });
        }

        $response['chart'] = 'bar';
        $response['element'] = 'bar-chart';
        $response['data'] = $chartCollection->toDataTable();
        $response['options'] = BarChartOptions::newInstance()->setTitle($id)->toArray();
        $response['columns'] = BarChartColumns::newInstance()->getColumns();

        return $response;
    }
}
