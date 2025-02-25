<?php

use Illuminate\Http\Request;
use Modules\Tutorship\Http\Controllers\SpecialistReferralController;
use Modules\Tutorship\Http\Controllers\TutorshipController;
use Modules\Tutorship\Http\Controllers\TutorshipPdfController;
use Modules\Tutorship\Http\Controllers\TutorshipTypeController;

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
    Route::prefix('tutorships')->group(function () {
        Route::get('/tutorships/school-center/{school_center_id}/alumns',
            [TutorshipController::class, 'indexByAlumns'])->name('tutorships.tutorships.indexByAlumns');
        Route::get('/tutorships/school-center/{school_center_id}/teachers',
            [TutorshipController::class, 'indexByTeachers'])->name('tutorships.tutorships.indexByTeachers');
        Route::get('/tutorships/school-center/{school_center_id}',
            [TutorshipController::class, 'index'])->name('tutorships.tutorships.index');
        Route::get('/tutorships/{id}', [TutorshipController::class, 'show'])->name('tutorships.tutorships.show');
        Route::get('/pdf/{id}', [TutorshipPdfController::class, 'generatePDF'])->name('tutorships.tutorships.pdf');
        Route::get('/pdf-test/{id}',
            [TutorshipPdfController::class, 'generatePdfTest'])->name('tutorships.tutorships.pdf-test');
        Route::get('/pdfs/{id}', [TutorshipPdfController::class, 'generatePDFs'])->name('tutorships.tutorships.pdfs');
        Route::get('/tutorships/alumn/{alumn_id}',
            [TutorshipController::class, 'showByAlumn'])->name('tutorships.tutorships.showByAlumn');
        Route::post('/tutorships/school-center/{school_center_id}',
            [TutorshipController::class, 'store'])->name('tutorships.tutorships.store');
        Route::put('/tutorships/{id}', [TutorshipController::class, 'update'])->name('tutorships.tutorships.update');
        Route::delete('/tutorships/{id}',
            [TutorshipController::class, 'destroy'])->name('tutorships.tutorships.destroy');
        Route::get('/list/user',
            [TutorshipController::class, 'getAllTutorshipsUser'])->name('tutorships.list.user');

        Route::get('/types', [TutorshipTypeController::class, 'index'])->name('tutorships.types.index');
        Route::get('/types/{id}', [TutorshipTypeController::class, 'show'])->name('tutorships.types.show');
        Route::post('/types', [TutorshipTypeController::class, 'store'])->name('tutorships.types.store');
        Route::put('/types/{id}', [TutorshipTypeController::class, 'update'])->name('tutorships.types.update');
        Route::delete('/types/{id}', [TutorshipTypeController::class, 'destroy'])->name('tutorships.types.destroy');

        Route::get('/specialist-referrals',
            [SpecialistReferralController::class, 'index'])->name('tutorships.specialistReferrals.index');
        Route::get('/specialist-referrals/{id}',
            [SpecialistReferralController::class, 'show'])->name('tutorships.specialistReferrals.show');
        Route::post('/specialist-referrals',
            [SpecialistReferralController::class, 'store'])->name('tutorships.specialistReferrals.store');
        Route::put('/specialist-referrals/{id}',
            [SpecialistReferralController::class, 'update'])->name('tutorships.specialistReferrals.update');
        Route::delete('/specialist-referrals/{id}',
            [SpecialistReferralController::class, 'destroy'])->name('tutorships.specialistReferrals.destroy');
    });
});
