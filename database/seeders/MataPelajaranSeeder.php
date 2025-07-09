<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_mapel' => 'Matematika',
                'deskripsi' => 'Pelajaran tentang angka, operasi hitung, dan logika matematika.',
            ],
            [
                'nama_mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Pelajaran bahasa dan sastra Indonesia.',
            ],
            [
                'nama_mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Pelajaran bahasa Inggris dasar dan lanjutan.',
            ],
            [
                'nama_mapel' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Pelajaran tentang biologi, fisika, dan kimia.',
            ],
            [
                'nama_mapel' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Pelajaran geografi, ekonomi, dan sejarah.',
            ],
            [
                'nama_mapel' => 'Pendidikan Kewarganegaraan',
                'deskripsi' => 'Pelajaran tentang kewarganegaraan dan Pancasila.',
            ],
            [
                'nama_mapel' => 'Seni Budaya',
                'deskripsi' => 'Pelajaran seni rupa, musik, dan budaya daerah.',
            ],
            [
                'nama_mapel' => 'Pendidikan Jasmani',
                'deskripsi' => 'Pelajaran olahraga dan kesehatan.',
            ],
            [
                'nama_mapel' => 'Prakarya',
                'deskripsi' => 'Pelajaran keterampilan dan kerajinan.',
            ],
            [
                'nama_mapel' => 'Informatika',
                'deskripsi' => 'Pelajaran komputer dan teknologi informasi.',
            ],
        ];

        foreach ($data as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}
