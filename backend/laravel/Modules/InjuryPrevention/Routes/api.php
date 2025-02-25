<?php

use Illuminate\Support\Facades\Route;
use Modules\InjuryPrevention\Http\Controllers\InjuryPreventionController;
use Modules\InjuryPrevention\Http\Controllers\PreventiveProgramTypeController;
use Modules\InjuryPrevention\Http\Controllers\EvaluationQuestionController;
use Modules\InjuryPrevention\Http\Controllers\InjuryPreventionEvaluationAnswerController;

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
    Route::get('/injury-prevention/preventive-program-types', [PreventiveProgramTypeController::class, 'index']);
    Route::get('/injury-prevention/evaluation-questions', [EvaluationQuestionController::class, 'index']);
    Route::get('/injury-prevention/list/user', [InjuryPreventionController::class, 'getAllInjuriesPreventionUser']);

    Route::prefix('injury-prevention/{team}')->group(function () {
        // Player routes
        Route::prefix('players')->group(function () {
            Route::get('/', [InjuryPreventionController::class, 'players']);

            // Specific player file routes
            Route::prefix('/{player}')->group(function () {
                Route::get('/', [InjuryPreventionController::class, 'index']);
                Route::post('/', [InjuryPreventionController::class, 'store']);
                Route::get('/show/{injuryPrevention}', [InjuryPreventionController::class, 'show']);
                Route::put('/update/{injuryPrevention}', [InjuryPreventionController::class, 'update']);
                Route::delete('/delete/{injuryPrevention}', [InjuryPreventionController::class, 'destroy']);

                // Answers routes
                Route::post('/finalize/{injuryPrevention}', [InjuryPreventionEvaluationAnswerController::class, 'store']);
                Route::put('/finalize/{injuryPrevention}', [InjuryPreventionEvaluationAnswerController::class, 'update']);

                // PDF routes
                Route::get('/pdf/{injuryPrevention}', [InjuryPreventionController::class, 'generatePdf']);
                Route::get('/pdfs', [InjuryPreventionController::class, 'generatePdfs']);
            });
        });
    });
});
