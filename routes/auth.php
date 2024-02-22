<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SendSmsController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyMobileController;
use App\Http\Controllers\home\user\DashboardsettingController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {

    Route::get('verify-mobile', [VerifyMobileController::class, 'create'])->name('verification.mobile')->middleware(['throttle:verify']);

    Route::get('verify-mobile-Verifymobile', [VerifyMobileController::class, 'Verifymobile2'])->name('verification.Verifymobile')
        ->middleware(['throttle:verify']);

    Route::get('verify-mobile-Verifymobile/{mobile}', [VerifyMobileController::class, 'Verifymobile'])
        ->middleware(['throttle:verify']);
//    ->middleware('throttle:verify');

    Route::post('verify-mobile', [VerifyMobileController::class, 'store'])->name('create.mobile');

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
//        ->middleware(['throttle:verify']);

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('mobile-login', [AuthenticatedSessionController::class, 'mobilelogin']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');


    Route::get('send-mobile-sms', [PasswordResetLinkController::class, 'sendmobilesms'])
        ->name('send.mobile.sms')->middleware(['throttle:verify']);

    Route::get('resend-mobile-value/{mobile}', [PasswordResetLinkController::class, 'Verifymobile'])
        ->middleware(['throttle:verify']);

    Route::post('change-mobile-password', [PasswordResetLinkController::class, 'changemobilepassword'])
        ->name('change.mobile.password');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::get('new-password', [PasswordResetLinkController::class, 'resetpassword'])->name('new.password');

    Route::get('change-password', [PasswordResetLinkController::class, 'changepassword'])->name('change.password');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {

    Route::post('send-sms', [SendSmsController::class, 'SendSmsData'])->name('send.sms')->middleware(['throttle:verify']);

    Route::post('get-user-notification-setting', [DashboardsettingController::class, 'GetSetting'])->name('get.user.setting');

    Route::post('edit-user-notification-setting', [DashboardsettingController::class, 'update'])->name('edit.user.setting');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
