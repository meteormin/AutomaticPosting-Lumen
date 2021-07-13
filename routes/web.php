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

$router->get('/', 'PostsController@index');

$router->get('posts/{id}', 'PostsController@show');

// stand alone page only include header
$router->get('api/posts/{id}', 'PostsController@show');

// api: json response
$router->group(['prefix' => 'api', 'middleware' => 'client'], function () use ($router) {
    // 섹터 리스트 조회
    $router->get('sectors', 'SectorController@index');

    //  시장 별 섹터 리스트 조회
    $router->get('sectors/{market}', 'SectorController@show');

    $router->post('sectors/{market}', 'SectorController@store');

    // 테마 리스트 조회
    $router->get('themes', 'ThemeController@index');

    // 테마 리스트 저장
    $router->post('themes', 'ThemeController@store');

    //  get sotck list
    $router->get('stocks/sectors', 'StockController@sectors');

    //  섹터 별 종목리스트
    $router->get('stocks/sectors/{code}', 'StockController@showStockBySector');

    // get sotck list
    $router->get('stocks/themes', 'StockController@themes');

    // 테마별 종목리스트
    $router->get('stocks/theme/{code}', 'StockController@showStockByTheme');

    // raw 데이터
    $router->get('absolute/raw/{name}', 'AbsoluteController@raw');

    // 정리된 데이터
    $router->get('absolute/refine/{name}', 'AbsoluteController@refine');

    //  종목정보 저장하기 method = sector or theme
    $router->post('stocks/{method}', 'StockController@storeStock');

    /**
     * open dart
     */
    // Open Dart 기업 코드 가져오기
    $router->get('corp-code', 'StockController@showCorpCode');

    // Open Dart 기업 코드 저장
    $router->post('corp-codes', 'StockController@storeCorpCodes');
});

// infographics
$router->group(['prefix' => 'infographics'], function () use ($router) {
    $router->get('/', [
        'as' => 'infographics.home',
        'uses'=>'InfoGraphics\MainController@index'
    ]);

    $router->get('/{type}/{code}','InfoGraphics\MainController@show');
});
