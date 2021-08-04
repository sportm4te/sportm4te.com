<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SportChooseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Auth\LoginController;

Route::domain('app.sportm4te.com')->group(function() {
    Route::group(['as' => 'users.', 'prefix' => 'users', 'middleware' => 'auth:web'], function () {
        Route::get('/list', [UsersController::class, 'list'])->name('list');
    });

    Route::group(['middleware' => 'guest'], function () {
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

        // $this->get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        // $this->get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    });

    Route::get('/about', [AboutController::class, 'index'])->name('about');

    Route::group(['as' => 'events.', 'prefix' => 'events', 'middleware' => 'auth:web'], function () {
        Route::get('/me', [EventController::class, 'me'])->name('me');
        Route::get('/{sport}/list', [EventController::class, 'index'])->name('sport');
        Route::get('/list', [EventController::class, 'index'])->name('list');
        Route::get('/new', [EventController::class, 'create'])->name('make');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::get('/{event}', [EventController::class, 'detail'])->name('detail');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/sport-choose', [SportChooseController::class, 'index'])->name('sport-choose');
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
        Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::post('provider/register', [SocialController::class, 'store'])->name('provider.register-setup');
    Route::any('login/{provider}/callback', [SocialController::class, 'callback'])->name('provider.login-callback');
    Route::get('login/{provider}', [SocialController::class, 'redirect'])->name('provider.login');
    Route::get('terms', [\App\Http\Controllers\TermsController::class, 'terms'])->name('terms');
});
