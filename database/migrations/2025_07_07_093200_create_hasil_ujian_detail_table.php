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
        Schema::create('hasil_ujian_detail', function (Blueprint $table) {
            $table->id();

            // Relasi ke hasil ujian
            $table->unsignedBigInteger('hasil_ujian_id');
            $table->foreign('hasil_ujian_id')->references('id')->on('hasil_ujians')->onDelete('cascade');

            // Relasi ke soal
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals')->onDelete('cascade');

            // Jawaban peserta
            $table->enum('jawaban_peserta', ['A', 'B', 'C', 'D']);

            // Status jawaban (benar/salah)
            $table->enum('status_jawaban', ['benar', 'salah']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian_detail');
    }
};
