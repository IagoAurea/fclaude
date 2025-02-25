<?php

use Illuminate\Support\Facades\Route;
use Modules\Fisiotherapy\Http\Controllers\FisiotherapyController;
use Modules\Fisiotherapy\Http\Controllers\FileController;
use Modules\Fisiotherapy\Http\Controllers\TreatmentController;
use Modules\Fisiotherapy\Http\Controllers\DailyWorkController;

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
    Route::get('fisiotherapy/list/user', [FisiotherapyController::class, 'getAllFileFisiotherapyUser']);

    Route::prefix('fisiotherapy/{team_id}')->group(function () {
        // Player routes
        Route::prefix('players')->group(function () {
            Route::get('/', [FisiotherapyController::class, 'players']);

            Route::post('/test', [FisiotherapyController::class, 'testApplication']);

            // Specific player file routes
            Route::prefix('/{player_id}/files')->group(function () {
                Route::get('/', [FileController::class, 'index']);
                Route::post('/', [FileController::class, 'store']);
                Route::get('/{file_id}', [FileController::class, 'show']);
                Route::put('/{file_id}', [FileController::class, 'update']);
                Route::delete('/{file_id}', [FileController::class, 'destroy']);
    
                Route::get('/{file_id}/test', [FisiotherapyController::class, 'showTestApplication']);

                Route::prefix('/{file_id}/daily-work')->group(function () {
                    Route::get('/', [DailyWorkController::class, 'index']);
                    Route::post('/', [DailyWorkController::class, 'store']);
                    Route::get('/{daily_work_id}', [DailyWorkController::class, 'show']);
                    Route::put('/{daily_work_id}', [DailyWorkController::class, 'update']);
                    Route::delete('/{daily_work_id}', [DailyWorkController::class, 'destroy']);
                });
            });
        });
    });

    // Treatment index
    Route::get('/fisiotherapy/treatments', [TreatmentController::class, 'index']);
});
