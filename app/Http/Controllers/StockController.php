<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use App\Services\Libraries\ConfigParser;
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
        $entities = $this->openDart->getMultiple(['005935']);

        return $this->response($entities, 200);
    }

    public function getSetctors(string $market)
    {
        $config = new ConfigParser('sector');

        if ($config->has($market)) {
            return $this->response($config->get($market), 200);
        } else {
            $market_sector = $config->findByAttribute(['market_code' => $market]);
            if (!$market_sector->empty()) {
                return $this->response($market_sector, 200);
            }
        }

        return $this->response($config, 200);
    }


    public function storeStock(Request $request)
    {
        $stock = $request->all();

        Storage::disk('local')->put('kiwoom/', json_encode($stock));

        return $this->response($stock, 201);
    }
}
