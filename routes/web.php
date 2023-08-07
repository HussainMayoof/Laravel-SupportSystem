<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\VerificationController;

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

Route::get('/', function () {
    return redirect('tickets');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth', 'middleware' => 'notverified', 'prefix' => 'email'], function() {
    Route::get('/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
    Route::put('/changeEmail', [VerificationController::class, 'change'])->name('verification.change');
});


Route::group(['middleware'=>'auth', 'middleware'=>'verified'], function() {
    Route::resource('tickets', TicketController::class)->except('destroy');
    Route::post('comments', [CommentController::class, 'store']);

    Route::group(['middleware'=>'admin'], function() {
        Route::resource('users', UserController::class)->only('index', 'show', 'update');
        Route::resource('logs', LogController::class)->only('index','show');
        Route::resource('categories', CategoryController::class);
        Route::resource('labels', LabelController::class);
    });
});