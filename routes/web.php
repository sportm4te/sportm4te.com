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
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\SportCenters;
use App\Http\Controllers\SettingsController;
use App\Htpp\Controllers\TutorialController;
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

Route::domain(config('app.domain'))->group(function() {
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

        //$this->get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        //$this->get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
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

        // *************MESSENGER ROUTES ****************

        Route::get('Inbox', [MessengerController::class, 'index'])->name('Inbox');
        Route::get('/home', [MessengerController::class, 'index'])->name('home');
        Route::get('/Conversation/{id}/{name}', [MessengerController::class, 'conversation'])->name('Conversation/{id}/{name}');
        Route::post('/send_message/{id}', [MessengerController::class, 'send_message'])->name('send_message/{id}');
        Route::get('/block/{id}', [MessengerController::class, 'block'])->name('block/{id}');
        Route::get('/unblock/{id}', [MessengerController::class, 'unblock'])->name('unblock/{id}');
        Route::post('/create_group', [MessengerController::class, 'create_group'])->name('create_group');
        Route::post('/add_member/{id}', [MessengerController::class, 'add_member'])->name('add_member/{id}');
        Route::get('/Group/{id}/{name}', [MessengerController::class, 'group'])->name('Group/{id}/{name}');
        Route::get('/leave_group', [MessengerController::class, 'leave_group'])->name('leave_group');
        Route::get('/make_host/{group_id}/{member_id}', [MessengerController::class, 'make_host'])->name('make_host/{group_id}/{member_id}');
        Route::get('/kick_out/{group_id}/{member_id}', [MessengerController::class, 'kick_out'])->name('kick_out/{group_id}/{member_id}');
        Route::post('/send_message_to_group/{id}', [MessengerController::class, 'send_message_to_group'])->name('send_message_to_group/{id}');

        // *************MESSENGER ROUTES END****************
    });

    Route::post('provider/register', [SocialController::class, 'store'])->name('provider.register-setup');
    Route::any('login/{provider}/callback', [SocialController::class, 'callback'])->name('provider.login-callback');
    Route::get('login/{provider}', [SocialController::class, 'redirect'])->name('provider.login');
    Route::get('terms', [\App\Http\Controllers\TermsController::class, 'terms'])->name('terms');
   

    // Route::get('/clear-cache', function () {
    //     Artisan::call('cache:clear');
    //     return redirect()->back();
    // });

    // *************Sport Centers Rouutes Start*********

    Route::get('/sport-center', [\App\Http\Controllers\SportController::class, 'index'])->name('sport-centers');
    Route::get('/sport-details/{name}', [\App\Http\Controllers\SportController::class, 'details']);
        // *************Sport Centers Rouutes END*********

    Route::get('/tutorial', [\App\Http\Controllers\TutorialController::class, 'index']);
    Route::post('/tutorial-add', [\App\Http\Controllers\TutorialController::class, 'add']);
});
