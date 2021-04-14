<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Response\ApiResponse;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $res = $router->app->version();
    return $res;
});

$router->group(['prefix' => 'api', 'middleware' => 'client'], function () use ($router) {

    $router->post('stocks/corp-codes', 'StockController@storeCorpCodes');

    $router->get('sectors', 'SectoController@index');

    $router->get('sectors/{market}', 'SectorController@show');

    $router->get('stocks', 'StockController@index');

    $router->post('stocks', 'StockController@store');
});
