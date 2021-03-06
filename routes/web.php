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
//敏感词列表-webDriver方法
Route::get('/test2','linkController@test2');
Route::get('/inputWords','linkController@inputWords');
Route::get('/getWordP','linkController@getWordP');
Route::get('/getWordsUrl','linkController@getWordsUrl');
Route::get('/htmlExport','linkController@htmlExport');

//word文档测试
//Route::get('/word','WordController@test');
Route::post('/word-post','WordController@getWordDoc');
Route::get('/word',function (){
    return view('word.word');
});
Route::get('/docx','docxController@index');

//curl
Route::get('/curl','CurlController@index');

//360
Route::get('/getWordP360','linkController@getWordP360');
Route::get('/getWordsUrl360','linkController@getWordsUrl360');

//搜狗
Route::get('/getWordPSg','linkController@getWordPSg');
Route::get('/getWordsUrlSg','linkController@getWordsUrlSg');

//phpquery test
Route::get('/pqTest','phpQueryController@pqTest');
Route::get('/singlePqTest','singlephpQueryController@singlePqTest');

//翻译功能
Route::get('/translate','TranslateController@index'); //?q=中国&lanType=en

Route::get('airport','AirPortController@index');
Route::get('test','AirPortController@test');
Route::get('email','AirPortController@sendemail');

Route::post('airport','AirPortController@post');
Route::post('airportarray','AirPortController@postArray');

Route::get('vue/todos','VueTodosController@index');
Route::get('vue/todos-component','VueTodosController@component');

Route::get('packages/pdf','PackagesController@pdf');

Route::get('/', function (\Illuminate\Http\Request $request) {
    dd('tools');
});

//断路器测试
Route::get('breaker/testBreaker','BreakerController@testBreaker')
->middleware(['breaker']);

//Route::get('api/todos',function (){
//    return response()->json([
//        ['id'=>1,'title'=>'learn vue.js','completed'=>false],
//        ['id'=>2,'title'=>'learn laravel','completed'=>false],
//    ]);
//})->middleware();

//Route::get('layui/table/edit','');
