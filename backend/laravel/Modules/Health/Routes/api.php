<?php

use Illuminate\Support\Facades\Route;

use Modules\Health\Http\Controllers\AllergyController;
use Modules\Health\Http\Controllers\DiseaseController;
use Modules\Health\Http\Controllers\PhysicalProblemController;
use Modules\Health\Http\Controllers\TypeMedicineController;
use Modules\Health\Http\Controllers\AlcoholConsumptionController;
use Modules\Health\Http\Controllers\TobaccoConsumptionController;
use Modules\Health\Http\Controllers\AreaBodyController;

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
    Route::prefix('health')->group(function () {
			Route::get('/allergies', [AllergyController::class, 'index']);
			Route::get('/diseases', [DiseaseController::class, 'index']);
    	Route::get('/physical-extension-problems', [PhysicalProblemController::class, 'index']);
    	Route::get('/type-medicines', [TypeMedicineController::class, 'index']);
    	Route::get('/alcohol-consumptions', [AlcoholConsumptionController::class, 'index']);
    	Route::get('/tobacco-consumptions', [TobaccoConsumptionController::class, 'index']);
    	Route::get('/areas-body', [AreaBodyController::class, 'index']);
    });
});