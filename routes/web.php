<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Component\AjaxController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Page\TrainerController;
use App\Http\Controllers\Page\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

Route::name('page.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/trainer', [TrainerController::class, 'index'])->name('trainer');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', static function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::name('ajax.')->prefix('ajax/')->group(function () {
    Route::get('/')->name('link');
    Route::post('/open-modal', [AjaxController::class, 'open_modal'])->name('open-modal');
    Route::post('/search-in-class', [AjaxController::class, 'search_in_class'])->name('search-in-class');
});

Route::name('auth.')->prefix('auth/')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/get_code', [PhoneVerificationController::class, 'get_code'])->name('get_code');
});
