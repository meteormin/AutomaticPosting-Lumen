<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request)
    {
        $stock = $request->all();

        Storage::disk('local')->put('kiwoom/', json_encode($stock));

        return response()->json($stock);
    }
}
