<?php


namespace App\Http\Controllers\InfoGraphics;

use App\Http\Controllers\Controller;
use App\Services\Infographics\Service;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\View\View;
use JsonMapper_Exception;
use Laravel\Lumen\Application;

class MainController extends Controller
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
     * @return View|Application
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function index()
    {
        return view('sb-admin.content');
    }

    /**
     * @param Request $request
     * @param string $type
     * @param string $code
     * @return View|Application
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function show(Request $request, string $type, string $code)
    {
        $treemap = $this->service->getTreeMapChart($type, $code);
        $barchart = $this->service->getBarChart($type, $code);

        return view('sb-admin.category', ['google_chart' => ['treemap' => $treemap, 'bar' => $barchart]]);
    }
}
