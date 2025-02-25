<?php

use Illuminate\Support\Facades\Route;

// Controllers
use Modules\Activity\Http\Controllers\ActivityController;

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
Route::middleware(['auth:api'])->group(function () {
    Route::get('activities', [ActivityController::class, 'index']);
    Route::get('activities/user', [ActivityController::class, 'listByUser']);
    Route::get('activities/{team_id}/team', [ActivityController::class, 'listByTeam']);
    Route::get('activities/user/clubs', [ActivityController::class, 'listRelatedByUser']);
});
