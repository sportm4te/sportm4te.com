<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::domain('api.sportm4te.com')->group(function() {
    Route::group(['middleware' => ['guest'], 'as' => 'api.', 'prefix' => 'user'], function () {
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
        Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::post('/register', [RegisterController::class, 'register']);

        // $this->post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    });

    Route::group(['middleware' => ['jwt.verify'], 'as' => 'api.'], function () {
        Route::post('/places', [PlaceController::class, 'autocomplete'])->name('places');

        Route::group(['as' => 'friends.', 'prefix' => 'friends'], function () {
            Route::post('/{friend}/remove', [FriendController::class, 'removeFriend'])->name('remove');
            Route::post('/{user}/request', [FriendController::class, 'requestFriend'])->name('request');
            Route::post('/{user}/request-respond', [FriendController::class, 'requestRespondFriend'])->name('request-respond');
        });

        Route::group(['as' => 'events.', 'prefix' => 'events'], function () {
            Route::post('/{event}/update', [EventController::class, 'updateEvent'])->name('update');
            Route::post('/create', [EventController::class, 'createEvent'])->name('create');
            Route::post('/{event}/register', [EventController::class, 'registerEvent'])->name('register');
            Route::post('/{event}/score', [EventController::class, 'saveEventScore'])->name('score');
            Route::post('/{event}/request', [EventController::class, 'saveJoinRequest'])->name('join.request');
            Route::post('/{event}/remove', [EventController::class, 'removeEvent'])->name('remove');
            Route::post('/request/hide', [EventController::class, 'hideRequest'])->name('hide.request');
            Route::group(['as' => 'teams.', 'prefix' => 'teams'], function () {
                Route::post('/{event}/create', [EventController::class, 'createTeam'])->name('create');
            });
        });

        Route::group(['as' => 'user.'], function () {
            Route::post('me', [UserController::class, 'me']);

            Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
                Route::post('update', [SettingsController::class, 'settings'])->name('update');
                Route::post('password', [SettingsController::class, 'passwordChange'])->name('password');
            });
        });

        Route::any("{fallbackPlaceholder}", function () {
            return ['error' => 'Invalid route.'];
        });
    });
});
