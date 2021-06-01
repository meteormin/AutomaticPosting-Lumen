<?php


namespace App\Http\Controllers\InfoGraphics;


use App\Http\Controllers\Controller;
use App\Services\Main\MainService;

class MainController extends Controller
{
    /**
     * @var MainService
     */
    protected MainService $service;

    public function __construct(MainService $service){
        $this->service = $service;
    }

    public function index(){
        return view('sb-admin.content',['google_chart'=>[]]);
    }
}
