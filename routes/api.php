<?php

Route::group(['namespace' => 'Api'], function() {
	Route::get('categories', 'CategoriesController@index'); // TODO: check if not used
	Route::get('products', 'ProductsController@index');
	Route::get('product-details', 'ProductsController@productDetails');
	Route::post('phone-click', 'ProductsController@increasePhoneClicks');
	Route::post('favourite', 'ProductsController@favAndUnfavProduct');
	Route::get('units', 'UnitsController@index'); // TODO: check if not used
	Route::get('seller-info', 'Seller\AccountController@sellerInfo');
	Route::get('app-options', 'OptionsController@index');
	Route::post('add-complaint', 'ComplaintsController@addComplaint');
	Route::post('app-review', 'ReviewsController@addReview');
	Route::get('product-reviews', 'User\ProductReviewsController@index');

	Route::group(['prefix' => 'seller', 'namespace' => 'Seller'], function() {
		Route::post('login', 'LoginController@login');
		Route::post('register', 'RegisterController@register');
		Route::get('receive-smscode', 'RegisterController@receiveSmsCode');
		Route::get('resend-smscode', 'RegisterController@resendSmsCode');
		Route::group(['middleware' => 'seller.api.auth'], function() {
			Route::get('products', 'ProductsController@index');
			Route::post('add-product', 'ProductsController@addProduct');
			Route::post('update-product', 'ProductsController@updateProduct');
			Route::delete('delete-product', 'ProductsController@deleteProduct');
			Route::post('set-featured-product', 'ProductsController@setFeaturedProduct');
			Route::post('edit-personal-info', 'AccountController@editPersonalInfo');
			Route::post('edit-company-info', 'AccountController@editCompanyInfo');
			Route::post('change-password', 'AccountController@changePassword');
		});
	});

	Route::group(['prefix' => 'user', 'namespace' => 'User'], function() {
		Route::post('register', 'RegisterController@register');
		Route::group(['middleware' => 'user.api.auth'], function() {
			Route::get('info', 'AccountController@getInfo');
			Route::post('update-info', 'AccountController@updateInfo');
			Route::post('add-product-review', 'ProductReviewsController@addReview');
			Route::post('delete-product-review', 'ProductReviewsController@deleteReview');
		});
	});
});
