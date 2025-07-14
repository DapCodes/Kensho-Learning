<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSessionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

    // laravel impersonate
    Route::get('/impersonate/{id}', [ImpersonateController::class, 'impersonate'])->name('impersonate');
    Route::get('/impersonate-stop', [ImpersonateController::class, 'leave'])->name('impersonate.leave');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('admin.quiz-terbaru');
    Route::resource('quiz', QuizController::class);

    Route::patch('/quiz/{id}/toggle-aktivasi', [QuizController::class, 'toggleAktivasi'])->name('quiz.toggleAktivasi');

    Route::resource('kategori', KategoriController::class);
    Route::resource('users', UserController::class);

    Route::resource('matapelajaran', MataPelajaranController::class);

    Route::resource('kelas', KelasController::class);

    Route::prefix('penilaian')->name('penilaian.')->group(function () {

        // Route untuk menyimpan penilaian essay (batch update)
        // Simpan penilaian essay (batch update)
        Route::post('/update-grade/{id}', [PenilaianController::class, 'updateGrade'])
            ->name('updateGrade');

        // Reset penilaian essay
        Route::get('/reset-grading/{id}', [PenilaianController::class, 'resetGrading'])
            ->name('resetGrading');

        // Update nilai satu per satu
        Route::post('/update-single-grade/{id}', [PenilaianController::class, 'updateSingleGrade'])
            ->name('updateSingleGrade');

        // Debug status essay
        Route::get('/debug-essay/{id}', [PenilaianController::class, 'debugEssayStatus'])
            ->name('debugEssayStatus');

        Route::get('/data-nilai', [PenilaianController::class, 'dataNilai'])->name('dataNilai');

        Route::get('/penilaian/data-nilai', [PenilaianController::class, 'dataNilai'])
            ->name('penilaian.dataNilai');

        Route::get('/penilaian/export-pengerjaan/{id}', [PenilaianController::class, 'exportPengerjaan'])
            ->name('penilaian.export-pengerjaan');

        // Tambahkan route detail di atas /{id}
        Route::get('/detail/{id}', [PenilaianController::class, 'detail'])->name('detail');

        Route::get('/{id}', [PenilaianController::class, 'show'])->name('show');
        Route::post('/{id}/update-grade', [PenilaianController::class, 'updateGrade'])->name('updateGrade');
        Route::post('/bulk-grade', [PenilaianController::class, 'bulkGrade'])->name('bulkGrade');
    });

});
