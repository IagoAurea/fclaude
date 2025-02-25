<?php

use Illuminate\Support\Facades\Route;
use Modules\Psychology\Http\Controllers\PsychologyReportController;
use Modules\Psychology\Http\Controllers\PsychologySpecialistController;

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
    Route::prefix('psychologies')->group(function () {
        Route::prefix('reports')->group(function () {
            Route::post('/', [PsychologyReportController::class, 'create']);
            Route::get('/{id}', [PsychologyReportController::class, 'reportById']);
            Route::get('/{id}/pdf', [PsychologyReportController::class, 'reportPdf']);
            Route::get('/{player_id}/pdfs', [PsychologyReportController::class, 'reportsPdf']);
            Route::put('/{id}', [PsychologyReportController::class, 'update']);
            Route::delete('/{id}', [PsychologyReportController::class, 'delete']);
            Route::get('/list/user', [PsychologyReportController::class, 'getAllPsychologyReportsUser']);
        });
        Route::prefix('specialists')->group(function () {
            Route::get('/', [PsychologySpecialistController::class, 'index']);
        });
    });
});
