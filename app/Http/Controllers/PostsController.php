<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Main\PostsService;
use App\Services\Main\MainService;
use App\Services\Kiwoom\KoaService;
use App\Services\OpenDart\OpenDartService;
use App\Http\Controllers\DefaultController;
use Illuminate\View\View;
use JsonMapper_Exception;
use Laravel\Lumen\Application;

class PostsController extends DefaultController
{
    /**
     * Undocumented variable
     *
     * @var MainService
     */
    protected MainService $mainService;

    /**
     * Undocumented variable
     *
     * @var PostsService
     */
    protected PostsService $postsService;

    public function __construct(MainService $mainService, PostsService $postsService)
    {
        $this->mainService = $mainService;
        $this->postsService = $postsService;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return View|Application
     * @throws JsonMapper_Exception
     */
    public function index(Request $request)
    {
        return view('list', ['posts' => $this->postsService->paginate()]);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function show(Request $request, int $id)
    {
        if($request->is('api/posts/*')){
            return view('components.stand-alone',['post' => $this->postsService->find($id)]);
        }
        return view('post', ['post' => $this->postsService->find($id)]);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function refine(Request $request, string $name): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mainService->getRefinedData($name));
    }
}
