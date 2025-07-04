<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoriList = ['Matematika', 'Bahasa Inggris', 'IPA', 'IPS', 'Teknologi'];

        foreach ($kategoriList as $nama) {
            Kategori::create(['nama_kategori' => $nama]);
        }
    }
}
