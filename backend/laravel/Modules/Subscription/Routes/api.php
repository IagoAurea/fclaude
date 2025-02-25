<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\SubscriptionController;
use Modules\Subscription\Http\Controllers\LicenseController;
use Modules\Subscription\Http\Controllers\StripeWebhookController;

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

Route::post('/subscriptions', [SubscriptionController::class, 'store']);
Route::post('/subscriptions/create-setup-intent/{userId}', [SubscriptionController::class, 'createSetupIntent']);

Route::get('/subscriptions/licenses/{token}/handle', [LicenseController::class, 'handleInvite']);

Route::post('/method-payment', [SubscriptionController::class, 'methodPayment'])->middleware('throttle:5,1');

//Webhook route
Route::stripeWebhooks('webhook');

// Authenthicated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('subscriptions')->group(function () {
        Route::put('/', [SubscriptionController::class, 'update']);
        Route::post('/cancel', [SubscriptionController::class, 'cancel']);

        Route::post('/confirm-payment', [SubscriptionController::class, 'confirmPaymentSubscription']);
        Route::post('/update-quantity', [SubscriptionController::class, 'updateQuantitySubscription']);
        Route::post('/update-subscription', [SubscriptionController::class, 'update']);

        Route::prefix('/licenses')->group(function () {
            Route::get('/{subscription?}', [LicenseController::class, 'index']);
            Route::post('/single-invite', [LicenseController::class, 'singleInvite']);
            Route::put('/{code}/cancel', [LicenseController::class, 'cancel']);
            Route::post('/{code}/revoke', [LicenseController::class, 'revoke']);
            Route::get('/{code}/show', [LicenseController::class, 'show']);
            Route::get('/{code}/activities', [LicenseController::class, 'activities']);
        });
    });
});
