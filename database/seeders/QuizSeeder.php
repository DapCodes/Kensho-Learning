<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $kategoriIds = Kategori::pluck('id')->toArray();

        foreach (range(1, 5) as $i) {
            Quiz::create([
                'judul_quiz' => "Quiz Ke-$i",
                'deskripsi' => "Deskripsi untuk quiz ke-$i",
                'kode_quiz' => 'QUIZ'.rand(1000, 9999),
                'waktu_menit' => rand(10, 30),
                'kategori_id' => $kategoriIds[array_rand($kategoriIds)],
                'mata_pelajaran_id' => 2,
                'user_id' => 1,
                'tanggal_buat' => now(),
                'status' => 'Umum',
            ]);
        }
    }
}
