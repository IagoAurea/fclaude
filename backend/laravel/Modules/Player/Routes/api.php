<?php

use Illuminate\Support\Facades\Route;

use Modules\Player\Http\Controllers\SkillsController;
use Modules\Player\Http\Controllers\PlayerController;
use Modules\Health\Http\Controllers\AllergyController;
use Modules\Health\Http\Controllers\DiseaseController;
use Modules\Health\Http\Controllers\AreaBodyController;
use Modules\Player\Http\Controllers\LateralityController;
use Modules\Player\Http\Controllers\PunctuationController;
use Modules\Player\Http\Controllers\PlayerInjuryController;
use Modules\Player\Http\Controllers\PlayerSkillsController;
use Modules\Player\Http\Controllers\PlayerHealthController;
use Modules\Health\Http\Controllers\TypeMedicineController;
use Modules\Family\Http\Controllers\MaritalStatusController;
use Modules\Player\Http\Controllers\PlayerContractController;
use Modules\Psychology\Http\Controllers\PsychologyController;
use Modules\Injury\Http\Controllers\MechanismInjuryController;
use Modules\Player\Http\Controllers\ClubArrivalTypeController;
use Modules\Health\Http\Controllers\PhysicalProblemController;
use Modules\Player\Http\Controllers\LineupPlayerTypeController;
use Modules\Player\Http\Controllers\PlayerTrajectoryController;
use Modules\Health\Http\Controllers\AlcoholConsumptionController;
use Modules\Health\Http\Controllers\TobaccoConsumptionController;
use Modules\Scouting\Http\Controllers\PlayerStatisticsController;


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
// Authenticated routes
Route::middleware('auth:api')->group(function () {
	Route::prefix('players')->group(function () {
		Route::prefix('assessment')->group(function () {
			Route::prefix('skills')->group(function () {
				Route::get('', [SkillsController::class, 'index']);
				Route::post('', [SkillsController::class, 'store']);
				Route::get('/{code}', [SkillsController::class, 'show']);
				Route::post('/{code}', [SkillsController::class, 'update']);
				Route::delete('/{code}', [SkillsController::class, 'destroy']);
			});

			Route::prefix('punctuation')->group(function () {
				Route::get('', [PunctuationController::class, 'index']);
				Route::post('', [PunctuationController::class, 'store']);
				Route::get('/{code}', [PunctuationController::class, 'show']);
				Route::put('/{code}', [PunctuationController::class, 'update']);
				Route::delete('/{code}', [PunctuationController::class, 'destroy']);
			});

			Route::post('/{player_id}', [PlayerSkillsController::class, 'store']);
			Route::get('/{player_id}', [PlayerSkillsController::class, 'show']);
		});

		Route::get('/laterities', [LateralityController::class, 'index']);
		Route::get('/type-players', [LineupPlayerTypeController::class, 'index']);
		Route::get('/club-arrival-types', [ClubArrivalTypeController::class, 'index']);
		
		Route::get('/list/user', [PlayerController::class, 'getAllPlayersUser']);
		
		// External Health Players
		Route::get('/diseases', [DiseaseController::class, 'index']);
		Route::get('/allergies', [AllergyController::class, 'index']);
		Route::get('/physical-exertion-problems', [PhysicalProblemController::class, 'index']);
		Route::get('/type-medicines', [TypeMedicineController::class, 'index']);
		Route::get('/alcohol-consumptions', [AlcoholConsumptionController::class, 'index']);
		Route::get('/tobacco-consumptions', [TobaccoConsumptionController::class, 'index']);
		Route::get('/areas-body', [AreaBodyController::class, 'index']);
		
		// External Injury Endpoints
		Route::get('/mechanisms-injury', [MechanismInjuryController::class, 'index']);

		// External Family Endpoints
		Route::get('/marital-statuses', [MaritalStatusController::class, '__invoke']);

		// Crud Endpoints
		Route::get('/{teamId}', [PlayerController::class, 'index']);
		Route::get('/{teamId}/resumes', [PlayerController::class, 'resumes']);
		Route::get('/{teamId}/resume/{playerId}', [PlayerController::class, 'resume']);
		Route::post('/', [PlayerController::class, 'store']);
		Route::get('/view/{playerId}', [PlayerController::class, 'show']);
		Route::post('/{playerId}', [PlayerController::class, 'update']);
		Route::delete('/{player}', [PlayerController::class, 'destroy']);
		Route::get('/{player}/health', [PlayerHealthController::class, 'viewHealthStatus']);
		Route::post('/{player}/health', [PlayerHealthController::class, 'manageHealthStatus']);

		Route::get('/{playerId}/trajectory', [PlayerTrajectoryController::class, 'index']);
		Route::post('/{playerId}/trajectory', [PlayerTrajectoryController::class, 'store']);
		Route::get('/trajectory/{trajectoryId}', [PlayerTrajectoryController::class, 'show']);
		Route::post('/{playerId}/trajectory/{trajectoryId}', [PlayerTrajectoryController::class, 'update']);
		Route::delete('/trajectory/{trajectoryId}', [PlayerTrajectoryController::class, 'destroy']);

		Route::get('/{playerId}/contracts', [PlayerContractController::class, 'index']);
		Route::post('/{playerId}/contracts', [PlayerContractController::class, 'store']);
		Route::get('/contracts/{contractId}', [PlayerContractController::class, 'show']);
		Route::post('/{playerId}/contracts/{contractId}', [PlayerContractController::class, 'update']);
		Route::delete('/contracts/{contractId}', [PlayerContractController::class, 'destroy']);

		Route::get('{player}/statistics', [PlayerStatisticsController::class, 'getStatisticsByPlayer']);

		//Psychology
		Route::get('/{team_id}/psychology', [PsychologyController::class, 'playersWithPsychologyDataByTeam']);

		Route::prefix('injuries')->group(function () {
			Route::get('/{player}', [PlayerInjuryController::class, 'index']);
			Route::post('/{player}', [PlayerInjuryController::class, 'store']);
			Route::get('/show/{injury}', [PlayerInjuryController::class, 'show']);
			Route::delete('/{injury}', [PlayerInjuryController::class, 'destroy']);
		});
    });
});
