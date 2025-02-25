<?php

use Illuminate\Support\Facades\Route;
use Modules\Calculator\Http\Controllers\CalculatorController;

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

// Authenthicated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('calculator')->group(function () {
        Route::get('/items', [CalculatorController::class, 'index']);
        Route::post('/items', [CalculatorController::class, 'store']);
        Route::get('/history/{entity_id}', [CalculatorController::class, 'showHistoryList']);
        Route::get('/history/{entity_id}/show/{history_id}', [CalculatorController::class, 'showHistoryItem']);
    });
});
