<?php

use Illuminate\Support\Facades\Route;
use Modules\Injury\Http\Controllers\PhaseController;
use Modules\Injury\Http\Controllers\DailyWorkController;
use Modules\Injury\Http\Controllers\InjuryRfdController;
use Modules\Injury\Http\Controllers\PhaseDetailController;
use Modules\Injury\Http\Controllers\CurrentSituationController;
use Modules\Injury\Http\Controllers\ReinstatementCriteriaController;
use Modules\Injury\Http\Controllers\InjuryTypeController;
use Modules\Injury\Http\Controllers\InjuryTypeSpecController;
use Modules\Injury\Http\Controllers\InjuryExtrinsicFactorController;
use Modules\Injury\Http\Controllers\InjuryIntrinsicFactorController;
use Modules\Injury\Http\Controllers\InjuryLocationController;
use Modules\Injury\Http\Controllers\InjurySeverityController;
use Modules\Injury\Http\Controllers\ClinicalTestTypeController;
use Modules\Injury\Http\Controllers\InjuryController;
use Modules\Injury\Http\Controllers\InjurySituationController;
use Modules\Injury\Http\Controllers\MechanismInjuryController;

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
    Route::prefix('injuries')->group(function () {
        Route::get('types', [InjuryTypeController::class, 'index']);
        Route::get('types/{id}/specs', [InjuryTypeSpecController::class, 'index']);
        Route::get('extrinsic-factors', [InjuryExtrinsicFactorController::class, 'index']);
        Route::get('intrinsic-factors', [InjuryIntrinsicFactorController::class, 'index']);
        Route::get('severities', [InjurySeverityController::class, 'index']);
        Route::get('locations', [InjuryLocationController::class, 'index']);
        Route::get('clinical-test-types', [ClinicalTestTypeController::class, 'index']);
        Route::get('situation-types', [InjurySituationController::class, 'index']);
        Route::get('affected-side-types', [InjuryController::class, 'affectedSidesTypes']);
        Route::get('mechanisms-injury', [MechanismInjuryController::class, 'index']);

        Route::prefix('phases')->group(function () {
            Route::get('', [PhaseController::class, 'index']);
            Route::post('', [PhaseController::class, 'store']);
            Route::get('/{code}', [PhaseController::class, 'show']);
            Route::put('/{code}', [PhaseController::class, 'update']);
            Route::delete('/{code}', [PhaseController::class, 'destroy']);
        });

        Route::prefix('current-situation')->group(function () {
            Route::get('', [CurrentSituationController::class, 'index']);
            Route::post('', [CurrentSituationController::class, 'store']);
            Route::get('/{code}', [CurrentSituationController::class, 'show']);
            Route::put('/{code}', [CurrentSituationController::class, 'update']);
            Route::delete('/{code}', [CurrentSituationController::class, 'destroy']);
        });

        Route::prefix('reinstatement-criteria')->group(function () {
            Route::get('', [ReinstatementCriteriaController::class, 'index']);
            Route::post('', [ReinstatementCriteriaController::class, 'store']);
            Route::get('/{code}', [ReinstatementCriteriaController::class, 'show']);
            Route::put('/{code}', [ReinstatementCriteriaController::class, 'update']);
            Route::delete('/{code}', [ReinstatementCriteriaController::class, 'destroy']);
        });

        Route::prefix('daily-works')->group(function () {
            Route::get('/{code}/rfd', [DailyWorkController::class, 'index']);
            Route::post('', [DailyWorkController::class, 'store']);
            Route::get('/{code}', [DailyWorkController::class, 'show']);
            Route::put('/{code}', [DailyWorkController::class, 'update']);
            Route::delete('/{code}', [DailyWorkController::class, 'destroy']);
        });

        Route::prefix('phase-detail')->group(function () {
            Route::get('/{code}', [PhaseDetailController::class, 'getTestByPhase']);
            Route::post('/{code}', [PhaseDetailController::class, 'evaluatePhase']);
        });

        Route::get('', [InjuryRfdController::class, 'index']);
        Route::get('team/{team}', [InjuryRfdController::class, 'teamIndex']);
        Route::post('', [InjuryRfdController::class, 'store']);
        Route::get('/{code}', [InjuryRfdController::class, 'show']);
        Route::get('/{code}/advance', [InjuryRfdController::class, 'getAdvance']);
        Route::get('/players/injuries/{team_id}', [InjuryRfdController::class, 'listOfPlayersByRfd']);
        Route::get('/players/{player_id}/injuries', [InjuryRfdController::class, 'rfdAbstractByPlayer']);
        Route::get('/players/{player_id}/rfds', [InjuryRfdController::class, 'rfdHistoricByPlayer']);
        Route::put('/{code}', [InjuryRfdController::class, 'update']);
        Route::delete('/{code}', [InjuryRfdController::class, 'destroy']);
        Route::delete('closed/{code}', [InjuryRfdController::class, 'closed']);
        Route::get('/rfd/list/user', [InjuryRfdController::class, 'getAllInjuriesRfdUser']);
    });
});
