<?php


namespace App\Http\Controllers\InfoGraphics;

use App\Http\Controllers\Controller;
use App\Services\Infographics\Service;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
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
        $disk = Storage::disk('local');
        $files = $disk->files("kiwoom/theme/");
        $max = 0;
        $recent = 0;

        foreach ($files as $f) {
            if ($max < $disk->lastModified($f)) {
                $max = $disk->lastModified($f);
                $recent = explode('_', $f)[1];
                $recent = explode('.', $recent)[0];
            }
        }

        $treemap = $this->service->getTreeMapChart('theme', $recent);
        $barchart = $this->service->getBarChart('theme', $recent);
        return view('sb-admin.content', ['google_chart' => ['treemap' => $treemap, 'bar' => $barchart]]);
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
