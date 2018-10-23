<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('airport','AirPortController@index');
Route::get('test','AirPortController@test');

Route::post('airport','AirPortController@post');
Route::post('airportarray','AirPortController@postArray');

Route::get('vue/todos','VueTodosController@index');
