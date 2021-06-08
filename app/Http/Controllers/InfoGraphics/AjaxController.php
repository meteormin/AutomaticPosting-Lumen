<?php


namespace App\Http\Controllers\InfoGraphics;

use App\Data\DataTransferObjects\GoogleChartCollection;
use App\Data\DataTransferObjects\Refine;
use App\Data\DataTransferObjects\TreeMapChartData;
use App\Data\DataTransferObjects\TreeMapOptions;
use App\Http\Controllers\Controller;
use App\Services\Infographics\Service;
use App\Services\Main\MainService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use JsonMapper_Exception;
use Laravel\Lumen\Application;

class AjaxController extends Controller
{
    /**
     * @var Service
     */
    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return View|Application
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getTreeMapChart(Request $request)
    {
        $this->service->getTreeMapChart($request->get('type'), $request->get('code'));

        return view('sb-admin.content', ['google_chart' => $response ?? []]);
    }

    /**
     * @param Request $request
     * @return View|Application
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function getBarChart(Request $request)
    {
        $response = $this->service->getBarChart($request->get('type'), $request->get('code'));
        return view('sb-admin.content', ['google_chart' => $response ?? []]);
    }
}
