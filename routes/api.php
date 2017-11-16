<?php

Route::post('auth', 'UserAuthController@authenticate');
Route::group(['middleware' => 'jwt.auth'], function(){
	Route::get('test', function () {
		return JWTAuth::parseToken()->authenticate();
	});
});

Route::get('user', 'UserAuthController@getUser');



//________________
// Route to create a new role
Route::post('role', 'UserAuthController@createRole');
// Route to create a new permission
Route::post('permission', 'UserAuthController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'UserAuthController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'UserAuthController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
	// Protected route
	Route::get('users', 'UserAuthController@index');
});

// Authentication route
Route::post('authenticate', 'UserAuthController@authenticate');