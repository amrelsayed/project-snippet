<?php

use App\Category;
use App\Helpers;
use Illuminate\Support\Facades\Auth;

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

// redirects
Route::get('product-details/{id}/{name}', function ($id, $name) {
    return redirect('product/' . $id . '/' . Helpers::makeSlug($name));
});

Route::get('how_to_buy', function() {
    return redirect('/how-to-buy');
});

Route::get('/product/{id}', function($id) {
    $category = Category::find($id);
    if ($category) {
        return redirect('/categories/' . $category->slug . '/' . $id);
    } else {
        return redirect('/');
    }
});

/* Start: Website Routes */
Route::group(['namespace' => 'Website'], function() {
    Route::get('/', 'IndexController@index');
    Route::get('/categories', 'CategoriesController@index');
    Route::get('/categories/{slug}/{id}', 'CategoriesController@category');
    Route::get('/categories/{category_slug}/{category_id}/{sub_category_slug}', 'CategoriesController@subCategory');
    Route::get('/product/{id}/{slug}', 'ProductsController@details')->name('product-details');
    Route::get('/increase-product-phone-clicks', 'ProductsController@increasePhoneClicks');
    Route::get('/search', 'ProductsController@search');
    Route::get('/seller/{id}/products/', 'SellerController@products');
    Route::get('/about', 'PagesController@about');
    Route::get('/how-to-buy', 'PagesController@howToBuy');
    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{id}/{slug}', 'BlogController@show');
});
/* End: Website Routes */

/* Start: Admin Routes */
Route::group(['prefix' => 'admin','middleware' => ['auth','AdminMiddleware']], function () {
    Route::resources([
        'adminstrator' => 'Admin\AdminstratorController',
    ]);
});

Route::group(['prefix' => 'admin','middleware' => 'auth', 'namespace' => 'Admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::post('/', 'AdminController@index');

    Route::resources([
        'category' => 'CategoryController',
        'subCategory' => 'SubCategoryController',
        'feature' => 'FeatureController',
        'information' => 'InformationController',
        'seller' => 'SellerController',
        'campaign' => 'CampaignController',
        'ads' => 'BannerController',
        'notes' => 'FormNoteController',
        'product' => 'ProductController',
        'policy' => 'PolicyController',
        'unit' => 'UnitController',
        'posts' => 'PostsController',
    ]);
});
/* End: Admin Routes */


// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

