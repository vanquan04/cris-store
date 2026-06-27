<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'Admin\AuthController@handle');
Route::post('/user/login', 'Client\UserController@loginHandle');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product Images API - public read endpoint
Route::get('/product-images/{productId}', 'Client\ProductImageController@getProductImages');

Route::middleware('auth:sanctum')->group(function () {
    // Upload images for a product-color-config combination
    Route::post('/product-images/upload', 'Client\ProductImageController@store');
    
    // Delete an image
    Route::delete('/product-images/{imageId}', 'Client\ProductImageController@destroy');
    
    // Update image display order
    Route::post('/product-images/order', 'Client\ProductImageController@updateOrder');
    
    // Set image as main
    Route::post('/product-images/{imageId}/set-main', 'Client\ProductImageController@setAsMain');
    
    // Get product color-size combinations
    Route::get('/products/{productId}/combinations', 'Client\ProductImageController@getProductCombinations');
});
