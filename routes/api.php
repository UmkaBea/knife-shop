<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnifeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InventoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/knives', [KnifeController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::post('/cart/buy', [CartController::class, 'buy']);
    Route::post('/knives', [KnifeController::class, 'store']);
    Route::get('/inventory', [InventoryController::class, 'index']);
});





