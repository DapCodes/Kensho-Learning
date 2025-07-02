<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\KategoriController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dasbor', [FrontendController::class, 'index'])->name('dasbor');
Route::post('/quiz/cek-kode', [FrontendController::class, 'checkKode'])->name('quiz.checkKode');
Route::get('/quiz/{id}/detail', [FrontendController::class, 'detail'])->name('quiz.detail');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('admin.quiz-terbaru');
    Route::resource('quiz', QuizController::class);
    Route::resource('kategori', KategoriController::class);
});
