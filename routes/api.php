<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResources([
        'users' => \App\Http\Controllers\UsersController::class,
        'merchants' => \App\Http\Controllers\MerchantsController::class,
        'orders' => \App\Http\Controllers\OrdersController::class,
        'products' => \App\Http\Controllers\ProductsController::class,
    ]);

});


