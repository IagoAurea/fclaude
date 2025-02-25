<?php

use Illuminate\Http\Request;
use Modules\Test\Http\Controllers\TestController;
use Modules\Test\Http\Controllers\UnitController;
use Modules\Test\Http\Controllers\FormulaController;
use Modules\Test\Http\Controllers\QuestionController;
use Modules\Test\Http\Controllers\ResponseController;
use Modules\Test\Http\Controllers\TestTypeController;
use Modules\Test\Http\Controllers\UnitGroupController;
use Modules\Test\Http\Controllers\TestSubTypeController;
use Modules\Test\Http\Controllers\TypeValorationController;
use Modules\Test\Http\Controllers\TestApplicationController;
use Modules\Test\Http\Controllers\QuestionCategoryController;

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
    Route::prefix('tests')->group(function () {

        Route::prefix('formula')->group(function () {
            Route::post('', [FormulaController::class, 'store']);
        });

        Route::prefix('question-categories')->group(function () {
            Route::get('', [QuestionCategoryController::class, 'index']);
            Route::post('', [QuestionCategoryController::class, 'store']);
            Route::get('/{code}', [QuestionCategoryController::class, 'show']);
            Route::put('/{code}', [QuestionCategoryController::class, 'update']);
            Route::delete('/{code}', [QuestionCategoryController::class, 'destroy']);
        });

        Route::prefix('test-type')->group(function () {
            Route::get('', [TestTypeController::class, 'index']);
            Route::post('', [TestTypeController::class, 'store']);
            Route::get('/{code}', [TestTypeController::class, 'show']);
            Route::put('/{code}', [TestTypeController::class, 'update']);
            Route::delete('/{code}', [TestTypeController::class, 'destroy']);
        });

        Route::prefix('test-sub-type')->group(function () {
            Route::get('', [TestSubTypeController::class, 'index']);
            Route::get('/{test_type_code}/type', [TestSubTypeController::class, 'listBytype']);
            Route::post('', [TestSubTypeController::class, 'store']);
            Route::get('/{code}', [TestSubTypeController::class, 'show']);
            Route::put('/{code}', [TestSubTypeController::class, 'update']);
            Route::delete('/{code}', [TestSubTypeController::class, 'destroy']);
        });

        Route::prefix('type-valoration')->group(function () {
            Route::get('', [TypeValorationController::class, 'index']);
            Route::post('', [TypeValorationController::class, 'store']);
            Route::get('/{code}', [TypeValorationController::class, 'show']);
            Route::put('/{code}', [TypeValorationController::class, 'update']);
            Route::delete('/{code}', [TypeValorationController::class, 'destroy']);
        });

        Route::prefix('questions')->group(function () {
            Route::get('', [QuestionController::class, 'index']);
            Route::get('by-category/{code}', [QuestionController::class, 'questionsByCategory']);
            Route::post('', [QuestionController::class, 'store']);
            Route::get('/{code}', [QuestionController::class, 'show']);
            Route::put('/{code}', [QuestionController::class, 'update']);
            Route::delete('/{code}', [QuestionController::class, 'destroy']);
        });

        Route::prefix('responses')->group(function () {
            Route::get('', [ResponseController::class, 'index']);
            Route::post('', [ResponseController::class, 'store']);
            Route::get('/{code}', [ResponseController::class, 'show']);
            Route::put('/{code}', [ResponseController::class, 'update']);
            Route::delete('/{code}', [ResponseController::class, 'destroy']);
        });

        Route::prefix('application')->group(function () {
            Route::post('', [TestApplicationController::class, 'store']);
            Route::get('/{code}', [TestApplicationController::class, 'show']);
            Route::get('/alumn/{id}', [TestApplicationController::class, 'indexByAlumn']);
            Route::get('/player/{id}', [TestApplicationController::class, 'indexByPlayer']);
            Route::get('/list/user', [TestApplicationController::class, 'getAllTestsUser']);
            Route::get('/classroom/list/user', [TestApplicationController::class, 'getAllTestsClassroomUser']);
            Route::get('/{code}/pdf', [TestApplicationController::class, 'testApplicationPdf']);
        });

        Route::prefix('unit')->group(function () {
            Route::get('', [UnitController::class, 'index']);
            Route::post('', [UnitController::class, 'store']);
            Route::get('/{code}', [UnitController::class, 'show']);
            Route::put('/{code}', [UnitController::class, 'update']);
            Route::delete('/{code}', [UnitController::class, 'destroy']);
        });

        Route::prefix('unit-group')->group(function () {
            Route::get('', [UnitGroupController::class, 'index']);
            Route::get('/{code}', [UnitGroupController::class, 'show']);
        });

        Route::get('', [TestController::class, 'index']);
        Route::get('/{test_type_code}/type', [TestController::class, 'listByType']);
        Route::get('/{test_sub_type_code}/sub-type', [TestController::class, 'listBySubType']);
        Route::post('', [TestController::class, 'store']);
        Route::get('/{code}', [TestController::class, 'show']);
        Route::post('/{code}', [TestController::class, 'update']);
        Route::delete('/{code}', [TestController::class, 'destroy']);
        Route::get('/team/{team_id}/players', [TestApplicationController::class, 'index']);
        Route::get('/classroom/{classroom_id}/alumns', [TestApplicationController::class, 'indexAlumn']);
    });
});
