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
Route::get('carts/{cart}/items', 'CartItemController@index')->name('cart-items.index');
Route::post('carts/{cart}/items', 'CartItemController@store')->name('cart-items.store');
Route::patch('carts/{cart}/items/{item}', 'CartItemController@update')->name('cart-items.update');
Route::delete('carts/{cart}/items/{item}', 'CartItemController@destroy')->name('cart-items.destroy');
