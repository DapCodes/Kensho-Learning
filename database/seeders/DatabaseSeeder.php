<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            QuizSeeder::class,
            SoalSeeder::class,
        ]);
    }
}
