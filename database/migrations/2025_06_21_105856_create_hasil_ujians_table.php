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
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Relasi ke quiz
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            
            // Skor dalam bentuk persentase (0-100)
            $table->decimal('skor', 5, 2)->default(0);
            
            // Jumlah jawaban benar dan salah
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            
            // Total bobot semua soal
            $table->integer('total_bobot')->default(0);
            
            // Bobot yang diperoleh dari jawaban benar
            $table->integer('bobot_diperoleh')->default(0);
            
            // Waktu pengerjaan dalam menit (decimal untuk presisi)
            $table->decimal('waktu_pengerjaan', 8, 2)->default(0);
            
            // Tanggal ujian
            $table->date('tanggal_ujian');
            
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['user_id', 'quiz_id']);
            $table->index(['quiz_id', 'bobot_diperoleh']);
            $table->index(['quiz_id', 'skor']);
            
            // Unique constraint untuk mencegah duplikasi hasil ujian per user per quiz
            // Hapus jika user diizinkan mengulang ujian
            $table->unique(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};