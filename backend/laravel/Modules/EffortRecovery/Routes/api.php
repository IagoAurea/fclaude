<?php

use Illuminate\Support\Facades\Route;

// Controllers
use Modules\EffortRecovery\Http\Controllers\EffortRecoveryController;
use Modules\EffortRecovery\Http\Controllers\EffortRecoveryStrategyController;
use Modules\EffortRecovery\Http\Controllers\WellnessQuestionnaireController;
use Modules\EffortRecovery\Http\Controllers\WellnessQuestionnaireHistoryController;

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
    Route::prefix('effort-recovery')->group(function () {
        Route::get('/strategies', [EffortRecoveryStrategyController::class, 'index']);
        Route::get('/{team_id}/players', [EffortRecoveryController::class, 'listPlayers']);
        Route::get('/{team_id}/players/{player}', [EffortRecoveryController::class, 'index']);
        Route::post('/{player}', [EffortRecoveryController::class, 'store']);
        Route::get('/{player}/show/{effortRecovery}', [EffortRecoveryController::class, 'show']);
        Route::put('/{player}/update/{effortRecovery}', [EffortRecoveryController::class, 'update']);
        Route::delete('/{player}/delete/{effortRecovery}', [EffortRecoveryController::class, 'destroy']);
        Route::get('/list/user', [EffortRecoveryController::class, 'getAllEffortRecoveryUser']);

        // Questionnaire routes
        Route::put(
            '/{effort_id}/questionnaire/{questionnaire_id}',
            [WellnessQuestionnaireHistoryController::class, 'update']
        );
        Route::prefix('questionnaire')->group(function () {
            Route::get('/types', [WellnessQuestionnaireController::class, 'indexTypes']);
            Route::get('/items/{type_id}', [WellnessQuestionnaireController::class, 'indexItems']);

            // Historic related routes
            Route::get('/{effort_id}/history', [WellnessQuestionnaireHistoryController::class, 'index']);
            Route::post('/{effort_id}', [WellnessQuestionnaireHistoryController::class, 'store']);
        });

        // PDF routes
        Route::get('/{player}/pdf/{effortRecovery}', [EffortRecoveryController::class, 'generatePdf']);
        Route::get('/{player}/pdfs', [EffortRecoveryController::class, 'generatePdfs']);
    });
});
