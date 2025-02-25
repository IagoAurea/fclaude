<?php

use Illuminate\Support\Facades\Route;

// Controllers
use Modules\AlumnControl\Http\Controllers\DailyControlItemController;
use Modules\AlumnControl\Http\Controllers\DailyControlController;

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

Route::middleware('auth:api')->group(function () {
    Route::prefix('/daily-control')->group(function () {
        Route::get('/items', [DailyControlItemController::class, 'index']);
        Route::post('/items', [DailyControlItemController::class, 'store']);
        Route::get('/items/{dailyControlItem}', [DailyControlItemController::class, 'show']);
        Route::post('/items/{dailyControlItem}', [DailyControlItemController::class, 'update']);
        Route::delete('/items/{dailyControlItem}', [DailyControlItemController::class, 'destroy']);

        Route::prefix('/{classroom}')->group(function () {
            Route::get('/', [DailyControlController::class, 'index']);
            Route::post('/', [DailyControlController::class, 'store']);
            Route::get('/show/{alumn}', [DailyControlController::class, 'show']);
            Route::put('/', [DailyControlController::class, 'update']);
            Route::put('/reset', [DailyControlController::class, 'reset']);
        });
    });
});
