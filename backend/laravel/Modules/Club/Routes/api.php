<?php

use Illuminate\Support\Facades\Route;
use Modules\Club\Http\Controllers\AcademicPeriodController;
// Controllers
use Modules\Club\Http\Controllers\ClubController;
use Modules\Club\Http\Controllers\ClubInvitationController;
use Modules\Club\Http\Controllers\StaffController;
use Modules\Club\Http\Controllers\ClubStaffController;
use Modules\Club\Http\Controllers\PositionStaffController;
use Modules\Club\Http\Controllers\SchoolCenterTypeController;
use Modules\Club\Http\Controllers\AcademicYearController;

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

Route::get('/clubs/invitations/{code}/handle', [ClubInvitationController::class, 'handle']);

// Authenthicated routes
Route::middleware(['auth:api', 'verify_subscription:sport'])->group(function () {
    Route::prefix('clubs')->group(function () {
        Route::get('/school-types', [SchoolCenterTypeController::class, 'index']);

        Route::get('/{club}/invitations', [ClubInvitationController::class, 'index']);
        Route::get('/{club}/invitations/users/{user}/history', [ClubInvitationController::class, 'userInvitationsHistory']);
        Route::get('/{club}/invitations/members-list', [ClubInvitationController::class, 'usersIndex']);
        Route::get('/{club}/invitations/{code}', [ClubInvitationController::class, 'show']);
        Route::get('/{club}/invitations/{code}/status', [ClubInvitationController::class, 'status']);
        Route::put('/invitations/details/{code}', [ClubInvitationController::class, 'updatePermissions']);
        Route::put('/invitations/update', [ClubInvitationController::class, 'updateMultiplePermissions']);
        Route::post('invite', [ClubInvitationController::class, 'store']);
        Route::delete('/invitations/{code}', [ClubInvitationController::class, 'destroy']);

        Route::get('', [ClubController::class, 'index']);
        Route::post('', [ClubController::class, 'store']);
        Route::get('/{id}', [ClubController::class, 'show']);
        Route::post('/{id}', [ClubController::class, 'update']);
        Route::delete('/{id}', [ClubController::class, 'destroy']);
        Route::get('{id}/activities', [ClubController::class, 'activities']);

        Route::prefix('position-staff')->group(function () {
            Route::get('/staff', [PositionStaffController::class, 'index']);
            Route::post('/position', [PositionStaffController::class, 'store']);
            Route::get('/{code}', [PositionStaffController::class, 'show']);
            Route::put('/{code}', [PositionStaffController::class, 'update']);
            Route::delete('/{code}', [PositionStaffController::class, 'destroy']);
        });

        Route::prefix('/{club}/staffs')->group(function () {
            Route::get('/', [ClubStaffController::class, 'index']);
            Route::post('/', [ClubStaffController::class, 'store']);
            Route::get('/{staffUser}', [ClubStaffController::class, 'show']);
            Route::post('/{staffUser}/update', [ClubStaffController::class, 'update']);
            Route::delete('/{staffUser}', [ClubStaffController::class, 'delete']);
        });

        Route::post('/{club}/academic-year', [AcademicYearController::class, 'store']);
        Route::get('/academic-year/{academic_year_id}/periods', [AcademicPeriodController::class, 'index']);
        Route::post('/academic-year/{academic_year_id}/periods', [AcademicPeriodController::class, 'store']);

        Route::get('/{club}/teams-matches', [ClubController::class, 'teamsMatches']);
    });

    // Staff Routes
    Route::get('/staff/members', [StaffController::class, 'index']);
    Route::post('/staff', [StaffController::class, 'store']);
    Route::get('/staff/profile/{id}', [StaffController::class, 'show']);
    Route::post('/staff/{id}', [StaffController::class, 'update']);
    Route::delete('/staff/{id}', [StaffController::class, 'destroy']);
});
