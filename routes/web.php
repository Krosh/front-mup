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
});

Route::group(["prefix" => "cemetery"], function()
{
    Route::get("load/{idCemetery}","CemeteryController@loadCoordsFromSite");
    Route::get("{idCemetery}","CemeteryController@view");
});


Route::get("/map","CemeteryController@map");

Route::resource('cities', 'CitiesController');

Route::resource('cemeteries', 'CemeteriesController');
Route::post("/cemeteries/{id}/cadastr", "CemeteriesController@cadastr");


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
