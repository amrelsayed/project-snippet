<?php

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');

Route::group(['middleware' => 'seller'], function() {
	Route::get('/logout', 'Auth\LoginController@logout');

	Route::get('/', 'IndexController@index');
	Route::resource('products', 'ProductsController');
	Route::get('set-featured-product/{product_id}', 'ProductsController@setUnsetFeatured');
	Route::post('delete-product-image', 'ProductsController@deleteImage');
	Route::get('account', 'AccountController@index');
	Route::put('account/{seller_id}', 'AccountController@update');
});


