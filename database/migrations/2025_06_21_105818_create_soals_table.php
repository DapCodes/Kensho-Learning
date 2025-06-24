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
            $table->text('pertanyaan');
            $table->string('pilihan_a', 255);
            $table->string('pilihan_b', 255);
            $table->string('pilihan_c', 255);
            $table->string('pilihan_d', 255);
            $table->enum('jawaban_benar', ['A', 'B', 'C', 'D']);
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
