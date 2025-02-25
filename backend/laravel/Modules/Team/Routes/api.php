<?php

use Illuminate\Support\Facades\Route;
use Modules\Team\Http\Controllers\TeamController;
use Modules\Team\Http\Controllers\GenderController;
use Modules\Team\Http\Controllers\TeamTypeController;
use Modules\Team\Http\Controllers\TeamMatchController;
use Modules\Team\Http\Controllers\TypeLineupController;
use Modules\Team\Http\Controllers\TeamExerciseController;
use Modules\Team\Http\Controllers\TeamModalityController;
use Modules\Team\Http\Controllers\TeamStaffUserController;

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
	Route::prefix('teams/exercises')->group(function () {
		Route::middleware('role_or_permission:api')->group(function () {
			Route::put('/store-3d/{code}', [TeamExerciseController::class, 'storeData3D']);

			Route::post('/detail-3d/{code}', [TeamExerciseController::class, 'detailData3D']);

			Route::put('/status-3d/{code}', [TeamExerciseController::class, 'statusExercise3D']);
		});
	});
});

Route::middleware(['auth:api', 'verify_subscription:sport'])->group(function () {
	Route::prefix('teams')->group(function () {
		Route::get('/types', [TeamTypeController::class, 'index']);
		Route::get('/modalities/{sport}', [TeamModalityController::class, 'index']);
		Route::get('/genders', [GenderController::class, '__invoke']);

		Route::get('/{club?}', [TeamController::class, 'index']);
		Route::get('/list/user', [TeamController::class, 'listTeamsByUser']);
		Route::post('/', [TeamController::class, 'store']);
		Route::get('/{code}/show', [TeamController::class, 'show']);
		Route::get('players/{code}', [TeamController::class, 'getPlayersByTeam']);
		Route::put('/{code}', [TeamController::class, 'update']);
		Route::post('cover/{code}', [TeamController::class, 'updateCover']);
		Route::delete('/{code}', [TeamController::class, 'destroy']);

		Route::prefix('exercises')->group(function () {
			Route::get('/teams/{team?}', [TeamExerciseController::class, 'index']);
			Route::get('/{code}', [TeamExerciseController::class, 'show']);
			Route::post('/teams/{team?}', [TeamExerciseController::class, 'store']);
			Route::put('/{code}', [TeamExerciseController::class, 'update']);
			Route::delete('/{code}', [TeamExerciseController::class, 'delete']);
			Route::post('/thumbnail-3d/{code}', [TeamExerciseController::class, 'storeThumbnail3D']);

			Route::prefix('/{code}/files')->group(function () {
				Route::get('/', [TeamExerciseController::class, 'downloadFile']);
				Route::post('/', [TeamExerciseController::class, 'storeFile']);
			});
		});

		// TypeLineups
		Route::prefix("type-lineups")->group(function () {
			Route::get("/", [TypeLineupController::class, 'index']);
			Route::get("/sport/{sport_code}/{modality_code?}", [TypeLineupController::class, 'getAllBySportAndModality']);
		});

		// New Staff Reactoring Controller
		Route::prefix('/{team}/staffs')->group(function () {
			Route::get('/', [TeamStaffUserController::class, 'index']);
			Route::post('/', [TeamStaffUserController::class, 'store']);
			Route::get('/{staffUser}', [TeamStaffUserController::class, 'show']);
			Route::post('/{staffUser}/update', [TeamStaffUserController::class, 'update']);
			Route::delete('/{staffUser}', [TeamStaffUserController::class, 'delete']);
		});

		Route::get('/{team}/matches', [TeamMatchController::class, 'index']);
	});
});
