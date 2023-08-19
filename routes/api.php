<?php

use App\Actions\Auth\LoginUser;
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
Route::post('/login', LoginUser::class);


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResources([
        'users' => \App\Http\Controllers\UsersController::class,
        'merchants' => \App\Http\Controllers\MerchantsController::class,
        'orders' => \App\Http\Controllers\OrdersController::class,
        'products' => \App\Http\Controllers\ProductsController::class,
    ]);
});


