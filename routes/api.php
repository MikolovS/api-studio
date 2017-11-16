<?php

Route::post('auth', 'UserAuthController@authenticate');
Route::group(['middleware' => 'jwt.auth'], function(){
	Route::get('test', function () {
		return 11;
	});
});

Route::get('user', 'UserAuthController@getUser');