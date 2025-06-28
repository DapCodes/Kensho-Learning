<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\KategoriController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dasbor', [App\Http\Controllers\FrontendController::class, 'index'])->name('dasbor');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('admin.quiz-terbaru');
    Route::resource('quiz', QuizController::class);
    Route::resource('kategori', KategoriController::class);
});
