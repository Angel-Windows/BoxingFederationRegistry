<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Component\AjaxController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Page\TrainerController;
use App\Http\Controllers\Page\HomeController;

use App\Http\Controllers\PaymentController;

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
    Route::get('/test', static function () {
        return view('test_page');
    })->name('test');
    Route::get('/trainer', [TrainerController::class, 'index'])->name('trainer');
    Route::get('/class/{class_name}/{id}', [TrainerController::class, 'class_page'])->name('class');
    Route::get('/class/{class_name}/{id}/edit', [TrainerController::class, 'edit_page'])->name('class.edit_page');
    Route::post('/class/{class_name}/{id}/edit', [TrainerController::class, 'edit'])->name('class.edit');
    Route::post('/class/{class_name}/{id}/register_category', [TrainerController::class, 'register_category'])->name('class.register_category');
});
Route::get('/photos/{filename}', [AjaxController::class, 'show'])->name('photo.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', static function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::name('auth.')->prefix('auth/')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/get_code', [PhoneVerificationController::class, 'get_code'])->name('get_code');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::prefix('fondy')->name('fondy.')->group(function () {
        Route::get('/form', [PaymentController::class, 'form'])->name('form');
        // PAGE
        Route::post('/process-payment', [PaymentController::class, 'initiatePayment'])->name('processPayment');

        // CALLBACK
        Route::match(['get', 'post'], '/response-url', [PaymentController::class, 'response_url'])->name('response-url');
        Route::match(['get', 'post'], '/callback-url', [PaymentController::class, 'callback_url'])->name('callback-url');

    });
});

Route::name('ajax.')->prefix('ajax/')->group(function () {
    Route::get('/')->name('link');
    Route::post('/open-modal', [AjaxController::class, 'open_modal'])->name('open-modal');
    Route::post('/search-in-class', [AjaxController::class, 'search_in_class'])->name('search-in-class');
    Route::post('/upload-img', [AjaxController::class, 'upload_img'])->name('upload-img');
});

