<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnifeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/knives', [KnifeController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::post('/buy', [KnifeController::class, 'buy']);
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Вы вышли из системы']);
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
});





