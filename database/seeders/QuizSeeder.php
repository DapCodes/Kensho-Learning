<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Kategori;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $kategoriIds = Kategori::pluck('id')->toArray();

        foreach (range(1, 5) as $i) {
            Quiz::create([
                'judul_quiz'   => "Quiz Ke-$i",
                'deskripsi'    => "Deskripsi untuk quiz ke-$i",
                'kode_quiz'    => 'QUIZ' . rand(1000, 9999),
                'waktu_menit'  => rand(10, 30),
                'kategori_id'  => $kategoriIds[array_rand($kategoriIds)],
                'user_id'      => 1, // ganti dengan user ID yang sesuai
                'tanggal_buat' => now(),
                'status'       => 'Umum',
            ]);
        }
    }
}
