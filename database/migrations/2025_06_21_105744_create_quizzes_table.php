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
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['private', 'publish']);
            $table->dateTime('tanggal_buat')->default(DB::raw('CURRENT_TIMESTAMP'));

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
