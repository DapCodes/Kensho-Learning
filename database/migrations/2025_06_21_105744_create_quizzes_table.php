<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('judul_quiz', 255);
            $table->text('deskripsi')->nullable();
            $table->string('kode_quiz', 10)->unique();
            $table->integer('waktu_menit');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('mata_pelajaran_id'); // Tambahkan ini
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajarans')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Umum', 'Privat']);
            $table->enum('status_aktivasi', ['aktif', 'non aktif'])->default('aktif');
            $table->enum('pengulangan_pekerjaan', ['Boleh', 'Tidak']);
            $table->dateTime('tanggal_buat')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
