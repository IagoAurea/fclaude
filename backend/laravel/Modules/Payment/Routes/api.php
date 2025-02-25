<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\TaxController;

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

Route::prefix('iva')->group(function () {
    Route::get('', [TaxController::class, 'index']);
    Route::post('', [TaxController::class, 'store']);
    Route::get('/{id}', [TaxController::class, 'show']);
    Route::put('/{id}', [TaxController::class, 'update']);
    Route::delete('/{id}', [TaxController::class, 'destroy']);
});
