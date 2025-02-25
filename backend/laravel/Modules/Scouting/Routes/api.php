<?php

use Modules\Scouting\Http\Controllers\PlayerStatisticsController;
use Modules\Scouting\Http\Controllers\ScoutingActivityController;
use Modules\Scouting\Http\Controllers\ScoutingResultsController;
use Modules\Scouting\Http\Controllers\ScoutingController;
use Modules\Scouting\Http\Controllers\ActionController;

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
    Route::prefix('scouting')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Scouting Routes
        |--------------------------------------------------------------------------
        | It handles the Scouting Management per Competition Match:
        | - Update scouting (in_real_time)
        | - List of available scoutings per team
        | - Start scouting
        | - Pause scouting
        | - Finish scouting
        */
        Route::put('/{id}', [ScoutingController::class, 'update'])->name('scouting.update');
        Route::get('/available/{team}', [ScoutingController::class, 'index'])->name('scouting.available.byTeam');
        Route::get('/{competition_match_id}/status', [ScoutingController::class, 'show'])->name('scouting.show');
        Route::post('/{competition_match_id}/start', [ScoutingController::class, 'startScouting'])->name('scouting.status.start');
        Route::post('/{competition_match_id}/pause', [ScoutingController::class, 'pauseScouting'])->name('scouting.status.pause');
        Route::post('/{competition_match_id}/finish', [ScoutingController::class, 'finishScouting'])->name('scouting.status.finish');

        /*
        |--------------------------------------------------------------------------
        | Action Routes
        |--------------------------------------------------------------------------
        | It handles the Actions Management to be used for the Scouting Activities
        | - List of available actions
        */
        Route::get('/actions', [ActionController::class, 'index'])->name('scouting.action.index');
        Route::get('/actions/{sport_id}', [ActionController::class, 'show'])->name('scouting.action.show');
        Route::post('/actions', [ActionController::class, 'store'])->name('scouting.action.store');

        /*
        |--------------------------------------------------------------------------
        | Scouting Activity Routes
        |--------------------------------------------------------------------------
        | It handles the Scouting Activity Management per Competition Match
        | - List of available scoutings per team
        | - Record a scouting activity
        | - Update a scouting activity
        | - Destroy a scouting activity
        | - Undo the last scouting activity
        | - Redo the last scouting activity
        */
        Route::get('/{competition_match_id}/activities', [ScoutingActivityController::class, 'index'])->name('scouting.activity.index');
        Route::post('/{competition_match_id}/activity', [ScoutingActivityController::class, 'store'])->name('scouting.activity.store');
        Route::put('/activity/{activity}', [ScoutingActivityController::class, 'update'])->name('scouting.activity.update');
        Route::delete('/activity/{activity}', [ScoutingActivityController::class, 'destroy'])->name('scouting.activity.destroy');
        Route::post('/{competition_match_id}/undo', [ScoutingActivityController::class, 'undo'])->name('scouting.activity.undo');
        Route::post('/{competition_match_id}/redo', [ScoutingActivityController::class, 'redo'])->name('scouting.activity.redo');

        /*
        |--------------------------------------------------------------------------
        | Result Processing Routes
        |--------------------------------------------------------------------------
        | It handles the results processing for Competitions, Matches and Players:
        | - List of available side effects by sport
        | - Scouting Results by competition match
        */
        Route::get('/{sport_code}/side_effects', [ScoutingResultsController::class, 'sideEffects'])->name('scouting.results.sideEffects');
        Route::get('/{competition_match_id}/results', [ScoutingResultsController::class, 'show'])->name('scouting.results.byCompetitionMatch');
        Route::post('/{competition_match_id}/results', [ScoutingResultsController::class, 'store'])->name('scouting.results.store');
        Route::get('/{competition_match_id}/player/actions', [ScoutingResultsController::class, 'indexPlayerActions'])->name('scouting.results.player.index');
        Route::get('/player/{player_id}/latest-actions', [ScoutingResultsController::class, 'showLatestPlayerActions'])->name('scouting.results.player.lastGameActions');
        Route::get('/{competition_match_id}/player/{player_id}/actions', [ScoutingResultsController::class, 'showPlayerActions'])->name('scouting.results.player.show');
        Route::get('/{competition_match_id}/player/{player_id}/results', [ScoutingResultsController::class, 'showPlayerResults'])->name('scouting.results.player.details');

        Route::get(
            'competition/{competition_id}/player/{player_id}/resume',
            [PlayerStatisticsController::class, 'getStatisticsOfPlayersByCompetition']
        );
    });
});
