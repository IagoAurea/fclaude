<?php

use Illuminate\Support\Facades\Route;

// Controllers
use Modules\Exercise\Http\Controllers\ExerciseController;
use Modules\Exercise\Http\Controllers\ContentExerciseController;
use Modules\Exercise\Http\Controllers\DistributionExerciseController;
use Modules\Exercise\Http\Controllers\ExerciseEducationLevelController;
use Modules\Exercise\Http\Controllers\ExerciseContentBlockController;

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
    Route::prefix('exercises')->group(function () {
        Route::get('/{code}/pdf', [ExerciseController::class, 'generatePdf']);
        Route::get('/distributions', [DistributionExerciseController::class, 'index']);
        Route::get('/contents/{sport_code}', [ContentExerciseController::class, 'index']);

        Route::prefix('/{exercise_id}')->group(function () {
            Route::post('/teams/assign', [ExerciseController::class, 'addOrUpdateTeams']);
            Route::get('/teams/list', [ExerciseController::class, 'listTeams']);
            Route::post('/classrooms/assign', [ExerciseController::class, 'addOrUpdateClassrooms']);
            Route::get('/classrooms/list', [ExerciseController::class, 'listClassrooms']);
            Route::post('/user/like', [ExerciseController::class, 'updateLike']);
        });

        Route::prefix('education-levels')->group(function () {
           Route::get('/', [ExerciseEducationLevelController::class, 'index']);
           Route::post('/', [ExerciseEducationLevelController::class, 'store']);
           Route::get('/{educationLevel}', [ExerciseEducationLevelController::class, 'show']);
           Route::put('/{educationLevel}', [ExerciseEducationLevelController::class, 'update']);
           Route::delete('/{educationLevel}', [ExerciseEducationLevelController::class, 'destroy']);
        });

        Route::prefix('content-blocks')->group(function () {
            Route::get('/', [ExerciseContentBlockController::class, 'index']);
            Route::post('/', [ExerciseContentBlockController::class, 'store']);
            Route::get('/{contentBlock}', [ExerciseContentBlockController::class, 'show']);
            Route::put('/{contentBlock}', [ExerciseContentBlockController::class, 'update']);
            Route::delete('/{contentBlock}', [ExerciseContentBlockController::class, 'destroy']);
         });
    });
});
