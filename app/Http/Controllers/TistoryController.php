<?php

namespace App\Http\Controllers;

use App\Services\Tistory\TistoryClient;
use Illuminate\Http\Request;

class TistoryControlelr extends DefaultController
{
    /**
     * Undocumented variable
     *
     * @var TistoryClient
     */
    protected $client;

    public function __construct(TistoryClient $client)
    {
        $this->clinet;
    }

    public function auth(Request $request)
    {
        return response($this->client->authorize());
    }

    public function callback(Request $request)
    {
        return response($this->client->callback($request->get('code')));
    }
}
