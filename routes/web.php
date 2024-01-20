<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Required to work with postman
Route::get('/get-csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

//Product lists
Route::get('/product/{productId}', [\App\Http\Controllers\ProductController::class, 'productInfo']);
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'productView']);

//Product CRUD
Route::post('/product-add', [\App\Http\Controllers\ProductController::class, 'productAdd']);
Route::delete('/product-delete/{productId}', [\App\Http\Controllers\ProductController::class, 'productDelete']);
Route::put('/product-update/{productId}', [\App\Http\Controllers\ProductController::class, 'productUpdate']);
