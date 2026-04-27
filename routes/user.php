<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\ResetPasswordController;
use App\Http\Controllers\User\Auth\SocialiteController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\AuthorizationController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReviewController;

Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.submit');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller(RegisterController::class)->middleware(['guest'])->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->name('register.submit');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
    });

    Route::controller(ForgotPasswordController::class)->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller(SocialiteController::class)->group(function () {
        Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
        Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('user-data', [UserController::class, 'userData'])->name('data');
    Route::post('user-data-submit', [UserController::class, 'userDataSubmit'])->name('data.submit');

    Route::middleware('registration.complete')->group(function () {
        Route::controller(AuthorizationController::class)->group(function () {
            Route::get('authorization', 'authorizeForm')->name('authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
            Route::post('verify-email', 'emailVerification')->name('verify.email');
            Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        });
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('dashboard', 'home')->name('home');
            Route::any('payment/history', 'depositHistory')->name('deposit.history');
            Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            Route::get('notifications', 'notifications')->name('notifications');
            Route::get('read-notification/{id}', 'readNotification')->name('notification.read');
        });

        Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
            Route::get('', 'allOrders')->name('all');
            Route::get('pending', 'pendingOrders')->name('pending');
            Route::get('processing', 'processingOrders')->name('processing');
            Route::get('dispatched', 'dispatchedOrders')->name('dispatched');
            Route::get('completed', 'completedOrders')->name('completed');
            Route::get('canceled', 'canceledOrders')->name('canceled');
            Route::get('{order_number}', 'orderDetails')->name('details');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile-setting', 'profile')->name('profile.setting');
            Route::post('profile-setting', 'submitProfile')->name('profile.setting.update');
            Route::get('change-password', 'changePassword')->name('change.password');
            Route::post('change-password', 'submitPassword')->name('change.password.submit');

            Route::get('shipping-address', 'shippingAddress')->name('shipping.address');
            Route::post('shipping-address/store/{id?}', 'saveShippingAddress')->name('shipping.address.store');
            Route::post('shipping-address/delete/{id}', 'deleteShippingAddress')->name('shipping.address.delete');
        });

        Route::controller(ReviewController::class)->middleware('checkModule:product_review')->name('review.')->group(function () {
            Route::get('product-reviews', 'index')->name('index');
            Route::post('review/add', 'add')->name('add');
            Route::post('review/reply/{id}/{reply_id?}', 'reviewReply')->name('reply');
        });
    });
});
