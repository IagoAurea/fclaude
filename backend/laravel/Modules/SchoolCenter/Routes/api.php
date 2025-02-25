<?php

use Illuminate\Support\Facades\Route;

// Controllers
use Modules\SchoolCenter\Http\Controllers\SchoolCenterController;
use Modules\SchoolCenter\Http\Controllers\SchoolAcademicYearController;
use Modules\SchoolCenter\Http\Controllers\SchoolCenterTypeController;

// Authenthicated routes
Route::middleware(['auth:api', 'verify_subscription:teacher'])->group(function () {
    // Club routes
    Route::prefix('school-center')->group(function () {
        Route::get('/', [SchoolCenterController::class, 'index']);
        Route::post('/', [SchoolCenterController::class, 'store']);
        Route::get('/{id}', [SchoolCenterController::class, 'show']);
        Route::post('/{id}', [SchoolCenterController::class, 'update']);
        Route::delete('/{id}', [SchoolCenterController::class, 'destroy']);
        Route::get('/{schoolCenter}/alumns', [SchoolCenterController::class, 'alumns']);

        // Academical years endpoints
        Route::prefix('{school}/academic-years')->group(function () {
            Route::get('/', [SchoolAcademicYearController::class, 'index']);
            Route::post('/', [SchoolAcademicYearController::class, 'store']);
            Route::put('/{academicYear}', [SchoolAcademicYearController::class, 'update']);
            Route::delete('/{academicYear}', [SchoolAcademicYearController::class, 'destroy']);
        });
    });

    // Center Types Endpoints
    Route::prefix('school-center-types')->group(function () {
        Route::get('/', [SchoolCenterTypeController::class, 'index']);
    });
});
