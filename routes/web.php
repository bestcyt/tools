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

Route::get('/', function (\Illuminate\Http\Request $request) {
    dd($request->header());
});

Route::get('airport','AirPortController@index');
Route::get('test','AirPortController@test');
Route::get('email','AirPortController@sendemail');

Route::post('airport','AirPortController@post');
Route::post('airportarray','AirPortController@postArray');

Route::get('vue/todos','VueTodosController@index');
Route::get('vue/todos-component','VueTodosController@component');

Route::get('packages/pdf','PackagesController@pdf');

//Route::get('api/todos',function (){
//    return response()->json([
//        ['id'=>1,'title'=>'learn vue.js','completed'=>false],
//        ['id'=>2,'title'=>'learn laravel','completed'=>false],
//    ]);
//})->middleware();

//Route::get('layui/table/edit','');
