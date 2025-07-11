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
        Schema::create('hasil_ujian_details', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke hasil ujian
            $table->unsignedBigInteger('hasil_ujian_id');
            $table->foreign('hasil_ujian_id')->references('id')->on('hasil_ujians')->onDelete('cascade');
            
            // Relasi ke soal
            $table->unsignedBigInteger('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals')->onDelete('cascade');
            
            // Jawaban peserta - menggunakan text untuk mendukung semua tipe jawaban
            // Pilihan ganda: 'A', 'B', 'C', 'D'
            // Benar/Salah: 'benar', 'salah'
            // Checkbox: 'A,B,C' (comma separated)
            // Essay: teks bebas
            $table->text('jawaban_peserta')->nullable();
            
            // Status jawaban dengan opsi pending untuk essay
            $table->enum('status_jawaban', ['benar', 'salah', 'pending', 'sebagian', 'tidak dijawab'])->default('tidak dijawab');
            
            // Bobot soal dan bobot yang diperoleh untuk sistem scoring berdasarkan bobot
            $table->integer('bobot_soal')->default(1);
            $table->decimal('bobot_diperoleh', 8, 2)->default(0.00); // Ubah ke decimal untuk mendukung nilai pecahan
            
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['hasil_ujian_id', 'soal_id']);
            $table->index('status_jawaban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian_details');
    }
};