<?php

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Products
Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{product}', 'ProductController@show')->name('products.show');

// Categories
Route::get('categories', 'CategoryController@index')->name('categories.index');

// Carts
Route::post('carts', 'CartController@store')->name('carts.store');

// Cart Products
Route::get('carts/{cart}/products', 'CartProductController@index')->name('cart-products.index');
Route::post('carts/{cart}/products', 'CartProductController@store')->name('cart-products.store');
Route::patch('carts/{cart}/products/{product}', 'CartProductController@update')->name('cart-products.update');
Route::delete('carts/{cart}/products/{product}', 'CartProductController@destroy')->name('cart-products.destroy');

// Users
Route::post('users', 'UserController@store')->name('users.store');

// Auth
Route::post('auth/token', 'Auth\TokenController@issue')->name('auth-token.issue');
