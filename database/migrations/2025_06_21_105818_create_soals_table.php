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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->string('tipe');
            $table->text('pertanyaan');

            $table->string('pilihan_a')->nullable();
            $table->string('pilihan_b')->nullable();
            $table->string('pilihan_c')->nullable();
            $table->string('pilihan_d')->nullable();
            $table->string('pilihan_e')->nullable();
            $table->string('pilihan_f')->nullable();
            $table->string('pilihan_g')->nullable();
            $table->string('pilihan_h')->nullable();
            $table->string('pilihan_i')->nullable();
            $table->string('pilihan_j')->nullable();

            $table->text('jawaban_benar')->nullable();

            $table->integer('bobot')->default(0);

            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
