<?php

use Illuminate\Support\Facades\Route;
use Modules\Nutrition\Http\Controllers\DietController;
use Modules\Nutrition\Http\Controllers\NutritionController;
use Modules\Nutrition\Http\Controllers\SupplementController;
use Modules\Nutrition\Http\Controllers\WeightControlController;
use Modules\Nutrition\Http\Controllers\AthleteActivityController;
use Modules\Nutrition\Http\Controllers\NutritionalSheetController;


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

	Route::prefix('nutrition')->group(function () {

		Route::get('/team/{id}', [NutritionController::class, 'index']);

		Route::prefix('diets')->group(function () {
			Route::get('', [DietController::class, 'index']);
			Route::post('', [DietController::class, 'store']);
			Route::get('/{id}', [DietController::class, 'show']);
			Route::post('/{id}', [DietController::class, 'update']);
			Route::delete('/{id}', [DietController::class, 'destroy']);
		});

		Route::prefix('supplements')->group(function () {
			Route::get('', [SupplementController::class, 'index']);
			Route::post('', [SupplementController::class, 'store']);
			Route::get('/{id}', [SupplementController::class, 'show']);
			Route::post('/{id}', [SupplementController::class, 'update']);
			Route::delete('/{id}', [SupplementController::class, 'destroy']);
		});

		Route::prefix('nutritional-sheet')->group(function () {
			Route::post('', [NutritionalSheetController::class, 'store']);
			Route::get('/{id}', [NutritionalSheetController::class, 'show']);
			Route::get('/players/{player}', [NutritionalSheetController::class, 'showNutritionalSheetPlayer']);
			Route::get('/{id}/pdf', [NutritionalSheetController::class, 'sheetPdf']);
			Route::get('/{player_id}/pdfs', [NutritionalSheetController::class, 'sheetsPdf']);
			Route::get('/list/user', [NutritionalSheetController::class, 'getAllNutritionalSheetsUser']);
		});

		Route::prefix('weight-control')->group(function () {
			Route::get('/{id}', [WeightControlController::class, 'index']);
			Route::post('', [WeightControlController::class, 'store']);
		});

		Route::post('/athlete-activity-factor', [AthleteActivityController::class, 'getCalculationAthleteActivityFactor']);
	});
});
