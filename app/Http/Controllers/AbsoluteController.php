<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DefaultController;
use App\Services\Main\MainService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JsonMapper_Exception;
use Laravel\Lumen\Application;

class AbsoluteController extends DefaultController
{
    /**
     * Undocumented variable
     *
     * @var MainService
     */
    protected MainService $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $name
     * @return Application|View
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function index(Request $request, string $name = 'sector')
    {
        return view('post', $this->mainService->getRefinedData($name));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $name
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function raw(Request $request, string $name): JsonResponse
    {
        $where = null;
        if($request->has('where')){
            $where = $request->get('where');
        }

        return $this->response($this->mainService->getRawData($name,$where));
    }

    /**
     * @param Request $request
     * @param string $name
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function refine(Request $request, string $name): JsonResponse
    {
        $where = null;
        if($request->has('where')){
            $where = $request->get('where');
        }

        return $this->response($this->mainService->getRefinedData($name,$where));
    }
}
