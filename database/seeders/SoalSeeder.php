<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Soal;
use Illuminate\Database\Seeder;

class SoalSeeder extends Seeder
{
    public function run()
    {
        $quizzes = Quiz::all();

        foreach ($quizzes as $quiz) {
            foreach (range(1, 10) as $i) {
                Soal::create([
                    'quiz_id' => $quiz->id,
                    'pertanyaan' => "Pertanyaan ke-$i untuk {$quiz->judul_quiz}",
                    'pilihan_a' => 'Pilihan A',
                    'pilihan_b' => 'Pilihan B',
                    'pilihan_c' => 'Pilihan C',
                    'pilihan_d' => 'Pilihan D',
                    'jawaban_benar' => ['a', 'b', 'c', 'd'][rand(0, 3)],
                ]);
            }
        }
    }
}
