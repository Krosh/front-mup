<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get("/migrate",function()
{
    \Illuminate\Support\Facades\Artisan::call("migrate");
});

Route::group(["prefix" => "import"], function()
{
    Route::get("excel", "ImportController@excel");
    Route::get("xml", "ImportController@xml");
    Route::get("load", "ImportController@load_xml");
    Route::post("save", "ImportController@save_xml");
    Route::get("regsystem","ImportController@regsystem");
});

Route::group(["prefix" => "cemetery"], function()
{
    Route::get("load/{idCemetery}","CemeteriesController@loadCoordsFromSite");
});


Route::get("/map","CemeteriesController@map");

Route::resource('cities', 'CitiesController');

Route::get("/cemeteries/info", "CemeteriesController@info");
Route::get("/cemeteries/geojson", "CemeteriesController@geojson");
Route::post("/cemeteries/{id}/cadastr", "CemeteriesController@cadastr");
Route::resource('cemeteries', 'CemeteriesController');

Route::resource('graves', 'GravesController');

Route::get('/cemeteries/{id}/graves','GravesController@by_cemetery');
Route::get('/cemeteries/{id}/graves/create','GravesController@add');

Route::get('/deads/search','DeadsController@search');
Route::get('/deads/info','DeadsController@info');
Route::get('/deads/create/{idGrave}','DeadsController@create');
Route::resource('deads', 'DeadsController');


Route::get('/', function () {
    return view('welcome');
});

Route::get("/test", "CemeteriesController@test");

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/', 'HomeController@index')->name("base");
