<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\GenderController;
use Modules\User\Http\Controllers\ListController;

use Modules\User\Http\Controllers\Auth\LoginController;
use Modules\User\Http\Controllers\Auth\SocialController;
use Modules\User\Http\Controllers\UserExerciseController;
use Modules\User\Http\Controllers\UserPermissionController;
use Modules\User\Http\Controllers\Auth\VerifyEmailController;
use Modules\User\Http\Controllers\UserSubscriptionController;
use Modules\User\Http\Controllers\Auth\ResendEmailController;
use Modules\User\Http\Controllers\Auth\ForgotPasswordController;
use Modules\User\Http\Controllers\Auth\UserSearchController;

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

//Login route
Route::match(['post', 'put'], '/auth/login', [LoginController::class, 'login']);

//Login with Google
Route::post('/auth/login-google', [SocialController::class, 'login']);

//Request forgot
Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'forgot']);

//Reset forgot
Route::post('/auth/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.reset');

//Basic routes
Route::prefix('users')->group(function () {
    Route::get('/gender', [GenderController::class, 'index'])->middleware('throttle:10,1');
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/license-register', [UserController::class, 'registerByLicense']);
    Route::get('/search', [UserController::class, 'userSearch']);
    Route::get('/list', [ListController::class, 'list']);

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verify/resend', [ResendEmailController::class, '__invoke']);

});

// Authenthicated routes
Route::middleware('auth:api')->group(function () {
    // Logout route
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    // Users related endpoints
    Route::prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::get('/payment-method', [UserController::class, 'getPaymentMethod']);
        Route::post('/payment-method', [UserController::class, 'addPaymentMethod']);
        Route::delete('/payment-method', [UserController::class, 'deletePaymentMethod']);
        Route::post('/edit/{id}', [UserController::class, 'update']);
        Route::get('/invoices', [UserController::class, 'getInvoices']);
        Route::get('/invoices/{code}/pdf', [UserController::class, 'generateInvoicePdf']);

        Route::get('/subscriptions', [UserSubscriptionController::class, 'index']);

        Route::delete('/delete', [UserController::class, 'destroy']);

        Route::prefix('permissions')->group(function () {
            Route::get('', [UserController::class, 'getPermissions']);
            Route::post('/manage', [UserController::class, 'managePermissions']);

            // CRUD PERMISSION ITEMS
            Route::get('/list', [UserPermissionController::class, 'index']);
            Route::get('/assigned', [UserPermissionController::class, 'userPermissions']);
            Route::get('/by-entity', [UserPermissionController::class, 'getPermissionsByEntity']);
            Route::post('/assign', [UserPermissionController::class, 'assignPermissions']);

        });

        Route::get('/gender-identity', [GenderController::class, 'indexGenderIdentity']);
        
        Route::get('/exercises', [UserExerciseController::class, 'index']);

    });

});
