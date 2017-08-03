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

// Products
Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{product}', 'ProductController@show')->name('products.show');

// Categories
Route::get('categories', 'CategoryController@index')->name('categories.index');

// Carts
Route::post('carts', 'CartController@store')->name('carts.store');

// Cart Items
Route::post('carts/{cart}/items', 'CartItemController@store')->name('cart-items.store');