<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Services\OpenDart\OpenDartService;
use Illuminate\Support\Facades\Storage;

class StockController extends DefaultController
{
    /**
     * open dart service
     *
     * @var OpenDartService
     */
    protected $openDart;

    public function __construct(OpenDartService $OpenDartService)
    {
        $this->openDart = $OpenDartService;
    }

    public function index()
    {
        $entities = $this->openDart->getMultiple(['005935']);

        return $this->response($entities, 200);
    }

    public function store(Request $request)
    {
        $stock = $request->all();

        Storage::disk('local')->put('kiwoom/', json_encode($stock));

        return response()->json($stock);
    }
}
