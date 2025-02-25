<?php

use Illuminate\Http\Request;
use Modules\Qualification\Http\Controllers\QualificationController;
use Modules\Qualification\Http\Controllers\QualificationResultController;
use Modules\Qualification\Http\Controllers\QualificationPdfController;

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
    Route::prefix('qualification')->group(function () {
        Route::get('/school-section/{classroom_academic_year_id}', [QualificationController::class, 'index'])->name('qualification.qualification.index');
        Route::get('/results/school-section/{classroom_academic_year_id}', [QualificationResultController::class, 'index'])->name('qualification.results.index');
        Route::get('/{qualification_id}/alumns/{alumn_id}/school-section/{classroom_academic_year_id}', [QualificationResultController::class, 'show'])->name('qualification.results.show');
        Route::get('/{qualification_id}/alumn/{alumn_id}/classroom/{classroom_id}/pdf', [QualificationPdfController::class, 'generate']);
        Route::get('/alumn/{alumn_id}/classroom/{classroom_id}/pdf', [QualificationPdfController::class, 'generateAllPdf']);

        Route::get('/{id}', [QualificationController::class, 'show'])->name('qualification.qualification.show');
        Route::post('/', [QualificationController::class, 'store'])->name('qualification.qualification.store');
        Route::put('/{id}', [QualificationController::class, 'update'])->name('qualification.qualification.update');
        Route::delete('/{id}', [QualificationController::class, 'delete'])->name('qualification.qualification.delete');
        Route::get('/periods/{classroom_academic_year_id}', [QualificationController::class, 'periodsIndex'])->name('qualification.periods.index');
        Route::get('/rubrics/{classroom_academic_year_id}', [QualificationController::class, 'rubricsIndex'])->name('qualification.rubrics.index');
    });
});
