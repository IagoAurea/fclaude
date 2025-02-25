<?php

use Illuminate\Support\Facades\Route;
use Modules\Competition\Http\Controllers\CompetitionController;
use Modules\Competition\Http\Controllers\CompetitionMatchController;
use Modules\Competition\Http\Controllers\TypeCompetitionsController;
use Modules\Competition\Http\Controllers\TypeModalityMatchController;
use Modules\Competition\Http\Controllers\TestCategoryMatchController;
use Modules\Competition\Http\Controllers\CompetitionMatchLineupController;
use Modules\Competition\Http\Controllers\CompetitionMatchPlayerController;
use Modules\Competition\Http\Controllers\CompetitionRivalTeamController;

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

    Route::prefix('competitions')->group(function () {

        Route::get('/{id}', [CompetitionController::class, 'getById']);
        Route::get('/team/{team_id}', [CompetitionController::class, 'getAllByTeam']);
        Route::get('/{competition_id}/team/{team_id}/verify-matches', [CompetitionController::class, 'getVerifyMatchOfTeamByDate']);
        Route::post('/', [CompetitionController::class, 'store']);
        Route::delete('/{id}', [CompetitionController::class, 'delete']);
        Route::put('/{id}', [CompetitionController::class, 'update']);
        Route::get('/type-competitions/{sport_code}', [TypeCompetitionsController::class, 'index']); 
        Route::get('/test-categories/match', [TestCategoryMatchController::class, 'index']); 
        Route::get('/test-categories/type/{test_code}/match', [TestCategoryMatchController::class, 'getTypeTestCategories']); 
        Route::get('/match/type-modalities/{sport_code}', [TypeModalityMatchController::class, 'index']); 

        //Rival Teams
        Route::get('/rival-teams', [CompetitionRivalTeamController::class, 'index']);
        Route::post('/rival-teams/bulk', [CompetitionRivalTeamController::class, 'storeBulk']);
        Route::put('/rival-teams/bulk', [CompetitionRivalTeamController::class, 'updateBulk']);
        Route::get('/rival-teams/competition/{competition_id}', [
            CompetitionRivalTeamController::class,
            'getAllByCompetitionId'
        ]);

        Route::prefix('/rival-teams')->group(function () {
            Route::post('/store', [CompetitionRivalTeamController::class, 'store']);
            Route::put('/{id}', [CompetitionRivalTeamController::class, 'update']);
            Route::delete('/{id}', [CompetitionRivalTeamController::class, 'destroy']);
        });

        // Matches
        Route::get('/matches/competition/{competition_id}', [CompetitionMatchController::class, 'getByCompetition']);
        Route::post('/matches/add', [CompetitionMatchController::class, 'store']);
        Route::get('/matches/next/team/{team_id}', [CompetitionMatchController::class, 'nextMatches']);
        Route::get('/matches/recent/team/{team_id}', [CompetitionMatchController::class, 'recentMatchesByTeam']);
        Route::get('/{competition}/matches', [CompetitionMatchController::class, 'listMatches']);
        Route::get('/matches/recent', [CompetitionMatchController::class, 'recentMatches']);
        Route::get('/matches/user', [CompetitionMatchController::class, 'getAllMatchesUser']);
        
        Route::post('/matches/lineups/add', [CompetitionMatchLineupController::class, 'store']);
        Route::get(
            '/matches/lineups/competition/{competition_id}/last',
            [CompetitionMatchLineupController::class, 'getLastMatchLineup']
        );
        
        Route::post('/matches/players/bulk', [CompetitionMatchPlayerController::class, 'storeBulk']);
        Route::get(
            '/matches/players/competition/{competition_id}/last',
            [CompetitionMatchPlayerController::class, 'getLastMatchPlayersByCompetition']
        );
        Route::post('/matches/competition/{competition_id}/percept_effort', [CompetitionMatchPlayerController::class, 'perceptEffortPlayer']);

        Route::prefix('/{team}/matches')->group(function () {
            Route::get('/{match}', [CompetitionMatchController::class, 'show']);
            Route::put('/{match}', [CompetitionMatchController::class, 'update']);
        });
    });
});
