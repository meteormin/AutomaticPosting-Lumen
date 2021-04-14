<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Services\Libraries\ArrayParser;
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

    public function storeCorpCodes()
    {
        $bool = $this->openDart->saveCorpCodes();

        if ($bool) {
            return $this->response($bool, 200);
        }

        return $this->error(99, $bool);
    }

    public function index(Request $request)
    {
        $entities = $this->openDart->getMultiple(['005930']);

        return $this->response($entities, 200);
    }

    public function storeStock(Request $request)
    {
        $stock = $request->all();

        Storage::disk('local')->put('kiwoom/', json_encode($stock));

        return $this->response($stock, 201);
    }
}
