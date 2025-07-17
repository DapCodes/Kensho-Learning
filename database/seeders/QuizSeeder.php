<?php

// database/seeders/QuizSeeder.php

namespace Database\Seeders;

use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
         Quiz::create([
            'judul_quiz' => 'Bahasa Pemrograman Dasar',
            'deskripsi' => 'Quiz ini menguji pemahaman dasar mengenai bahasa pemrograman seperti sintaks, logika, dan konsep dasar pemrograman.',
            'kode_quiz' => 'QI82GY',
            'waktu_menit' => 60,
            'kategori_id' => 2,
            'mata_pelajaran_id' => 10,
            'user_id' => 1,
            'status_aktivasi' => 'Aktif',
            'tanggal_buat' => Carbon::now(),
            'pengulangan_pekerjaan' => 'Boleh',
            'status' => 'Umum',
        ]);


        Quiz::create([
            'judul_quiz' => 'Matematika Dasar (untuk anak kelas 2 SD)',
            'deskripsi' => 'Quiz ini dirancang untuk menguji pemahaman matematika dasar seperti penjumlahan, pengurangan, dan logika sederhana pada siswa kelas 2 SD.',
            'kode_quiz' => 'MTK2SD',
            'waktu_menit' => 45,
            'kategori_id' => 1,
            'mata_pelajaran_id' => 1,
            'user_id' => 1,
            'status_aktivasi' => 'Aktif',
            'tanggal_buat' => Carbon::now(),
            'pengulangan_pekerjaan' => 'Boleh',
            'status' => 'Umum',
        ]);

        $quizzes = [
            [
                'judul_quiz' => 'Bahasa Indonesia Dasar',
                'deskripsi' => 'Quiz ini menguji pemahaman dasar tentang tata bahasa, kosakata, dan sastra Indonesia.',
                'kode_quiz' => 'BIND01',
                'waktu_menit' => 60,
                'kategori_id' => 1,
                'mata_pelajaran_id' => 2,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Bahasa Inggris Elementary',
                'deskripsi' => 'Quiz bahasa Inggris tingkat dasar mencakup grammar, vocabulary, dan reading comprehension.',
                'kode_quiz' => 'ENG001',
                'waktu_menit' => 50,
                'kategori_id' => 1,
                'mata_pelajaran_id' => 3,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Biologi Dasar',
                'deskripsi' => 'Quiz tentang konsep-konsep dasar biologi seperti sel, ekosistem, dan sistem organ.',
                'kode_quiz' => 'BIO101',
                'waktu_menit' => 55,
                'kategori_id' => 2,
                'mata_pelajaran_id' => 4,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Sejarah Indonesia',
                'deskripsi' => 'Quiz tentang sejarah Indonesia dari masa pra-kolonial hingga kemerdekaan.',
                'kode_quiz' => 'HIST01',
                'waktu_menit' => 65,
                'kategori_id' => 1,
                'mata_pelajaran_id' => 5,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Fisika Dasar',
                'deskripsi' => 'Quiz fisika dasar mencakup mekanika, termodinamika, dan gelombang.',
                'kode_quiz' => 'PHY001',
                'waktu_menit' => 70,
                'kategori_id' => 2,
                'mata_pelajaran_id' => 4,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Geografi Indonesia',
                'deskripsi' => 'Quiz tentang kondisi geografis Indonesia, iklim, dan sumber daya alam.',
                'kode_quiz' => 'GEO001',
                'waktu_menit' => 60,
                'kategori_id' => 1,
                'mata_pelajaran_id' => 5,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
            [
                'judul_quiz' => 'Seni Budaya Nusantara',
                'deskripsi' => 'Quiz tentang keragaman seni dan budaya di Indonesia, termasuk tari, musik, dan kerajinan tradisional.',
                'kode_quiz' => 'SBD001',
                'waktu_menit' => 45,
                'kategori_id' => 1,
                'mata_pelajaran_id' => 7,
                'user_id' => 1,
                'status_aktivasi' => 'Aktif',
                'tanggal_buat' => Carbon::now(),
                'pengulangan_pekerjaan' => 'Boleh',
                'status' => 'Umum',
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}


