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

Route::get('/', function (){
    return bcrypt('123456');
});

Route::group(['prefix' => 'campaings'], function (){
    Route::get('/', 'CampaingsController@get');
    Route::get('up', 'CampaingsController@update');
});

Route::post('auth', 'UserAuthController@authenticate');
Route::group(['prefix' => 'history'], function(){
    Route::get('single/{historyId}', 'CampaingsController@getSingleHistory')->where('$historyId', '[0-9]+');
    Route::get('all', 'CampaingsController@getAllHistory');
    Route::post('type', 'CampaingsController@changeHistoryType');
});

Route::group(['prefix' => 'campaign'], function (){
    Route::post('change-limit', 'CampaingsController@changeLimit');
    Route::post('stop-parse', 'CampaingsController@stopParse');
});

Route::get('user', 'UserAuthController@getUser');