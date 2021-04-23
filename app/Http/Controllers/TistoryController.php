<?php

namespace App\Http\Controllers;

use App\Services\Tistory\TistoryClient;
use Illuminate\Http\Request;

class TistoryController extends DefaultController
{
    /**
     * Undocumented variable
     *
     * @var TistoryClient
     */
    protected $client;

    public function __construct(TistoryClient $client)
    {
        $this->client = $client;
    }

    public function auth(Request $request)
    {
        return redirect($this->client->authorize());
    }

    public function callback(Request $request)
    {
        return response($this->client->callback($request->get('code')));
    }
}
