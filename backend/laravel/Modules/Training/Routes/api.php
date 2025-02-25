<?php

use Illuminate\Support\Facades\Route;

use Modules\Training\Http\Controllers\WorkGroupController;
use Modules\Training\Http\Controllers\TrainingLoadController;
use Modules\Training\Http\Controllers\TargetSessionController;
use Modules\Training\Http\Controllers\TrainingPeriodController;
use Modules\Training\Http\Controllers\ExerciseSessionController;
use Modules\Training\Http\Controllers\SubContentSessionController;
use Modules\Training\Http\Controllers\TypeExerciseSessionController;
use Modules\Training\Http\Controllers\SubjecPerceptEffortController;
use Modules\Training\Http\Controllers\ExerciseSessionPlaceController;
use Modules\Training\Http\Controllers\ExerciseSessionDetailController;
use Modules\Training\Http\Controllers\ExerciseSessionExerciseController;
use Modules\Training\Http\Controllers\ExerciseSessionAssistanceController;
use Modules\Training\Http\Controllers\ExerciseSessionEffortAssessmentController;

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
	Route::prefix('training')->group(function () {
        
		Route::prefix('targets')->group(function () {
            Route::get('', [TargetSessionController::class, 'index']);
            Route::post('', [TargetSessionController::class, 'store']);
            Route::get('/{code}', [TargetSessionController::class, 'show']);
            Route::put('/{code}', [TargetSessionController::class, 'update']);
            Route::delete('/{code}', [TargetSessionController::class, 'destroy']);
            Route::get('content/{content_exercise_code}/{sport_code}',
                [TargetSessionController::class, 'listTargetsByContent']);
            Route::get('sub-content/{sub_content_session_code}/{sport_code}',
                [TargetSessionController::class, 'listTargetsBySubContent']);
        });
        
        Route::prefix('type-exercise-session')->group(function () {
            Route::get('', [TypeExerciseSessionController::class, 'index']);
            Route::post('', [TypeExerciseSessionController::class, 'store']);
            Route::get('/{code}', [TypeExerciseSessionController::class, 'show']);
            Route::put('/{code}', [TypeExerciseSessionController::class, 'update']);
			Route::delete('/{code}', [TypeExerciseSessionController::class, 'destroy']);
        });

        Route::prefix('training-periods')->group(function () {
            Route::get('', [TrainingPeriodController::class, 'index']);
            Route::post('', [TrainingPeriodController::class, 'store']);
            Route::get('/{code}', [TrainingPeriodController::class, 'show']);
            Route::put('/{code}', [TrainingPeriodController::class, 'update']);
			Route::delete('/{code}', [TrainingPeriodController::class, 'destroy']);
        });

        Route::prefix('subjective-perception-effort')->group(function () {
			Route::get('', [SubjecPerceptEffortController::class, 'index']);
        });

        Route::prefix('sub-content-session')->group(function () {
            Route::get('', [SubContentSessionController::class, 'index']);
            Route::get('/{code}/content', [SubContentSessionController::class, 'listByContent']);
            Route::post('', [SubContentSessionController::class, 'store']);
            Route::get('/{code}', [SubContentSessionController::class, 'show']);
            Route::put('/{code}', [SubContentSessionController::class, 'update']);
			Route::delete('/{code}', [SubContentSessionController::class, 'destroy']);
        });

        Route::prefix('work-groups')->group(function () {
            Route::get('/exercise-session/{exercise_session}/alumns', [WorkGroupController::class, 'listAlumns']);
            Route::get('/exercise-session/{exercise_session}/players', [WorkGroupController::class, 'listPlayers']);
            Route::get('/exercise-session/{exercise_session}/players-work-groups',
                [WorkGroupController::class, 'listWorkGroupWithPlayers']);
            Route::get('/exercise-session/{exercise_session}/alumns-work-groups',
                [WorkGroupController::class, 'listWorkGroupWithAlumns']);
            Route::get('/exercise-session/{exercise_session_id}', [WorkGroupController::class, 'index']);
            Route::post('', [WorkGroupController::class, 'store']);
            Route::get('/{code}', [WorkGroupController::class, 'show']);
            Route::put('/{code}', [WorkGroupController::class, 'update']);
            Route::delete('/{code}', [WorkGroupController::class, 'destroy']);
        });

        Route::prefix('exercise-sessions')->group(function () {
            Route::get('/{team}', [ExerciseSessionController::class, 'index']);
            Route::get('/{club}/places', [ExerciseSessionPlaceController::class, 'index']);
            Route::post('/{team}', [ExerciseSessionController::class, 'store']);
            Route::get('/{team}/show/{code}', [ExerciseSessionController::class, 'show']);
            Route::put('/{team}/update/{code}', [ExerciseSessionController::class, 'update']);
            Route::delete('/{team}/delete/{code}', [ExerciseSessionController::class, 'destroy']);
            Route::get('/{team}/materials/{code}/list', [ExerciseSessionController::class, 'listMaterials']);
            Route::post('/tests/sessions', [ExerciseSessionController::class, 'testApplication']);
            Route::get('/{code}/pdf', [ExerciseSessionController::class, 'generatePdf']);
            Route::post('/{exercise_session_id}/user/like', [ExerciseSessionController::class, 'updateLike']);
            Route::get('/{code}/team/{team}/list-exercises',
                [ExerciseSessionController::class, 'listExercisesTeam']);
            Route::get('/{code}/classroom/{classroom}/list-exercises',
                [ExerciseSessionController::class, 'listExercisesClassroom']);
            Route::put('/team/{team}/order', [ExerciseSessionController::class, 'updateOrderSessionTeam']);
            Route::put('/classroom/{classroom}/order',
                [ExerciseSessionController::class, 'updateOrderSessionClassroom']);
            Route::get('/{id}/tests/{type}/sessions/players/{player_id}',
                [ExerciseSessionController::class, 'showTestApplication']);
            Route::get('/all/team/user',
                [ExerciseSessionController::class, 'getAllExerciseSessionTeamUser']);
            Route::get('/all/classroom/user',
                [ExerciseSessionController::class, 'getAllExerciseSessionClassroomUser']);
        });

        Route::prefix('executions/exercise-sessions')->group(function () {
            Route::post('/', [ExerciseSessionDetailController::class, 'store']);
            Route::get('/', [ExerciseSessionDetailController::class, 'index']);
            Route::get('/{exercise_session_code}', [ExerciseSessionDetailController::class, 'lisBySession']);
            Route::get('/team/{team_id}', [ExerciseSessionDetailController::class, 'lisByTeam']);
        });

        Route::prefix('assistance/exercise-sessions')->group(function () {
            Route::post('/', [ExerciseSessionAssistanceController::class, 'store']);
            Route::get('/{exercise_session_code}/{academic_year_id?}',
                [ExerciseSessionAssistanceController::class, 'index']
            );
        });

        Route::prefix('effort-assessments/exercise-sessions')->group(function () {
            Route::post('/', [ExerciseSessionEffortAssessmentController::class, 'store']);
        });

        Route::prefix('training-load')->group(function () {
            Route::get('/{entity}/{id}', [TrainingLoadController::class, 'indexByEntity']);
        });

        Route::prefix('training-load-period')->group(function () {
            Route::get('/{entity}/{id}', [TrainingLoadController::class, 'indexPeriodByEntity']);
        });

        Route::prefix('exercises/exercise-sessions')->group(function () {
            Route::post('/', [ExerciseSessionExerciseController::class, 'store']);
            Route::put('/{code}', [ExerciseSessionExerciseController::class, 'update']);
            Route::get('/{code}', [ExerciseSessionExerciseController::class, 'show']);
            Route::delete('/{code}', [ExerciseSessionExerciseController::class, 'destroy']);
            Route::get('/{exercise_session_code}/{search}/{order}',
                [ExerciseSessionExerciseController::class, 'searchExercises']
            );
            Route::put('/{exercise_session_code}/exercises/order',
                [ExerciseSessionExerciseController::class, 'updateOrderExercises']
            );

        });
        
    });
});