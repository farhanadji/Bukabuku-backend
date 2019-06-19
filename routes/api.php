<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//private
Route::middleware(['auth:api'])->group(function () {
    Route::get('/apibooks','BookController@indexApi');
    Route::post('details', 'PassportController@details');
    Route::get('books','PassportController@books');
    Route::post('logoutapi', 'AuthController@logout');
    Route::post('shipping', 'ShopController@shipping');
    Route::post('services', 'ShopController@services');
    Route::post('payment', 'ShopController@payment');
    Route::get('my-order', 'ShopController@myOrder');
});

Route::post('login', 'PassportController@login');
Route::post('loginapi', 'AuthController@login');
Route::post('registerapi', 'AuthController@register');


//public
Route::group([
        'middleware' => ['api', 'cors'],
    ], function ($router) {
      	Route::get('categories/random/{count}','CategoryApiController@random');
      	Route::get('categories','CategoryApiController@index');
		Route::get('books/top/{count}','BookApiController@top');
		Route::get('booksapi', 'BookApiController@index');
		Route::get('categories/slug/{slug}', 'CategoryApiController@slug');
		Route::get('books/slug/{slug}', 'BookApiController@slug');
		Route::get('books/search/{keyword}', 'BookApiController@search');
        Route::get('provinces', 'ShopController@provinces');
        Route::get('cities', 'ShopController@cities');
        Route::get('kurir', 'ShopController@kurir');
    });

