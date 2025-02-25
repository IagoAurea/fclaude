<?php

use Illuminate\Support\Facades\Route;
use Modules\Sport\Http\Controllers\SportController;
use Modules\Sport\Http\Controllers\SportPositionController;

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
    Route::get('/sports', [SportController::class, 'index']);
    Route::get('/sports/{id}/positions', [SportPositionController::class, 'index']);
    Route::get('/positions/{posId}/specs', [SportPositionController::class, 'positionSpecs'])->whereNumber('posId');
});
