<?php

use Illuminate\Support\Facades\Route;
use Modules\Generality\Http\Controllers\CheckhealtController;
use Modules\Generality\Http\Controllers\SplashController;
use Modules\Generality\Http\Controllers\SeasonController;
use Modules\Generality\Http\Controllers\CountryController;
use Modules\Generality\Http\Controllers\JobAreaController;
use Modules\Generality\Http\Controllers\KinshipController;
use Modules\Generality\Http\Controllers\ProvinceController;
use Modules\Generality\Http\Controllers\RefereesController;
use Modules\Generality\Http\Controllers\StudyLevelController;
use Modules\Generality\Http\Controllers\TaxController;
use Modules\Generality\Http\Controllers\WeatherController;
use Modules\Generality\Http\Controllers\WeekDayController;

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

Route::middleware('throttle:10,1')->group(function () {
    Route::get('/countries', [CountryController::class, 'index']);

    Route::get('/countries/{country}/provinces', [ProvinceController::class, 'index']);

    Route::get('/splashs/{type}', [SplashController::class, 'index']);

    Route::get('/check-healt', [CheckhealtController::class, 'index']);
});

// Authenthicated routes
Route::middleware('auth:api')->group(function () {
    Route::get('/jobs-area', [JobAreaController::class, 'index']);
    Route::get('/study-levels', [StudyLevelController::class, 'index']);
    Route::get('/kinships', [KinshipController::class, 'index']);
    Route::get('/seasons', [SeasonController::class, 'index']);
    Route::get('/splashs', [SplashController::class, 'index']);
    Route::get('/week-days', [WeekDayController::class, 'index']);

    //Weathers
    Route::prefix("weathers")->group(function () {
        Route::get('/', [WeatherController::class, 'index']);
        Route::post('/', [WeatherController::class, 'store']);
        Route::put('/{id}', [WeatherController::class, 'update']);
        Route::delete('/{id}', [WeatherController::class, 'delete']);
    });

    // Referees
    Route::prefix("referees")->group(function () {
        Route::get('/{team_id?}', [RefereesController::class, 'index']);
        Route::post('/', [RefereesController::class, 'store']);
        Route::put('/{id}', [RefereesController::class, 'update']);
        Route::delete('/{id}', [RefereesController::class, 'delete']);
    });

    //Taxes
    Route::prefix("taxes")->group(function () {
        Route::post('/', [TaxController::class, 'store']);
        Route::put('/{tax_id}', [TaxController::class, 'update']);
        Route::delete('/{tax_id}', [TaxController::class, 'delete']);
    });
});

//Taxes

Route::middleware('throttle:10,1')->group(function () {
    Route::prefix("taxes")->group(function () {
        Route::get('/', [TaxController::class, 'index']);
        Route::get('/actives', [TaxController::class, 'showTaxesActive']);
        Route::get('/inactives', [TaxController::class, 'showTaxesNoActive']);
        Route::get('/{is_company}/{country_id}/{province_id?}', [TaxController::class, 'showTaxUser']);
        Route::get('/{tax_id}', [TaxController::class, 'showTaxId']);
    });
});