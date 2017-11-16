<?php

Route::post('auth', 'UserAuthController@authenticate');
Route::group(['middleware' => 'jwt.auth'], function(){
	Route::get('test', function () {
		return JWTAuth::parseToken()->authenticate();
	});
});

Route::get('user', 'UserAuthController@getUser');