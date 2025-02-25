<?php

use Illuminate\Support\Facades\Route;
use Modules\Alumn\Http\Controllers\AlumnController;
use Modules\Alumn\Http\Controllers\AcneaeController;
use Modules\Alumn\Http\Controllers\AlumnHealthController;
use Modules\Alumn\Http\Controllers\AlumnInjuryController;
use Modules\Alumn\Http\Controllers\AlumnEvaluationController;

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
	Route::prefix('acneae')->group(function () {
		Route::get('/types', [AcneaeController::class, 'index']);
	});

	Route::prefix('alumns')->group(function () {
		// Crud Endpoints
		Route::get('/{classroom}', [AlumnController::class, 'index']);
		Route::post('/', [AlumnController::class, 'store']);
		Route::get('/view/{alumn}', [AlumnController::class, 'show']);
		Route::get('/resume/{alumn}/classroom/{classroom_academic_year_id}', [AlumnEvaluationController::class, 'resume']);
		Route::get('/resume/classroom/{classroom_academic_year_id}', [AlumnEvaluationController::class, 'resumes']);
		Route::put('/{alumn}', [AlumnController::class, 'update']);
		Route::delete('/{alumn}', [AlumnController::class, 'destroy']);
		Route::get('/{alumn}/health', [AlumnHealthController::class, 'viewHealthStatus']);
		Route::post('/{alumn}/health', [AlumnHealthController::class, 'manageHealthStatus']);

		// Injury Endpoints
		Route::prefix('injuries')->group(function () {
			Route::get('/{alumn}', [AlumnInjuryController::class, 'index']);
			Route::post('/{alumn}', [AlumnInjuryController::class, 'store']);
			Route::get('/show/{injury}', [AlumnInjuryController::class, 'show']);
			Route::delete('/{injury}', [AlumnInjuryController::class, 'destroy']);
		});
	});
});
