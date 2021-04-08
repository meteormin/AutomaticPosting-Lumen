<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request)
    {
        $stock = $request->all();

        return response()->json($stock);
    }
}
