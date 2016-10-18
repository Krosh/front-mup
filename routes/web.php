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
    \Illuminate\Support\Facades\Artisan::call("migratge");
});

Route::group(["prefix" => "import"], function()
{
    Route::get("excel", "ImportController@excel");
    Route::get("xml", "ImportController@xml");
    Route::get("load", "ImportController@load_xml");
    Route::post("save", "ImportController@save_xml");

});


Route::get('/', function () {
    return view('welcome');
});
