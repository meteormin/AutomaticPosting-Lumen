<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->get('/', function () use ($router) {
//     $res = $router->app->version();
//     return $res;
// });

$router->get('tistory/callback', [
    'as' => 'tistory.callback',
    'uses' => 'TistoryController@callback'
]);

$router->get('/', function () {
    $list = [1, 2, 3, 4, 5];
    return view('list', ['list' => $list]);
});

$router->get('posts/{id}', 'AbsoluteController@index');

$router->group(['prefix' => 'api', 'middleware' => 'client'], function () use ($router) {
    $router->get('tistory/auth', 'TistoryController@auth');
    // Open Dart 기업 코드 저장
    $router->post('corp-codes', 'StockController@storeCorpCodes');
    // Open Dart 기업 코드 가져오기
    $router->get('corp-code', 'StockController@showCorpCode');
    // 섹터 리스트 가져오기
    $router->get('sectors', 'SectorController@index');
    //  시장 별 섹터 리스트 가져오기
    $router->get('sectors/{market}/{sector}', 'SectorController@show');

    //  get sotck list
    $router->get('stocks/sectors', 'StockController@sectors');

    //  단일 종목별 기본 주가 정보 가져오기
    $router->get('stocks/sectors/{code}', 'StockController@showStockBySector');

    $router->get('stocks/themes', 'StockController@themes');

    $router->get('stocks/theme/{code}', 'StockController@showStockByTheme');

    //  업종 별 종목정보 저장하기
    $router->post('stocks/{method}', 'StockController@storeStock');

    // raw 데이터
    $router->get('absolute/raw/{name}', 'AbsoluteController@raw');

    // 정리된 데이터
    $router->get('absolute/refine/{name}', 'AbsoluteController@refine');
});
