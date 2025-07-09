<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSessionController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

// Quiz routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dasbor', [FrontendController::class, 'index'])->name('dasbor');
    Route::get('/historiPengerjaan', [HasilUjianController::class, 'index'])->name('histori-pengerjaan');

    Route::get('/quiz/{id}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/hasil/{id}', [QuizController::class, 'hasil'])->name('quiz.hasil');
    Route::post('/quiz/{id}/session', [QuizSessionController::class, 'handleSession'])->name('quiz.session');
    Route::post('/quiz/{id}/complete', [QuizSessionController::class, 'completeSession'])->name('quiz.complete');
    Route::post('/quiz/cek-kode', [FrontendController::class, 'checkKode'])->name('quiz.checkKode');
    Route::get('/quiz/{id}/detail', [FrontendController::class, 'detail'])->name('quiz.detail');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('admin.quiz-terbaru');
    Route::resource('quiz', QuizController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('users', UserController::class);
});
