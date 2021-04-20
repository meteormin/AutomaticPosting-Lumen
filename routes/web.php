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

    // Open Dart 기업 코드 저장
    $router->post('corp-codes', 'StockController@storeCorpCodes');
    // Open Dart 기업 코드 가져오기
    $router->get('corp-code', 'StockController@showCorpCode');
    // 섹터 리스트 가져오기
    $router->get('sectors', 'SectorController@index');
    //  시장 별 섹터 리스트 가져오기
    $router->get('sectors/{market}', 'SectorController@show');
    //  Open dart 재무 정보 가져오기
    $router->get('stocks', 'StockController@index');
    //  종목별 기본 주가 정보 가져오기
    $router->get('stock', 'StockController@showStock');
    //  업종 별 종목정보 저장하기
    $router->post('stocks', 'StockController@storeStock');
    // raw 데이터
    $router->get('absolute/raw', 'AbsoluteController@raw');
    // 정리된 데이터
    $router->get('absolute', 'AbsoluteController@index');
});
