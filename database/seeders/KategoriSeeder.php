<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoriList = ['Umum', 'RPL', 'TBSM', 'TKRO', 'Lanjutan'];

        foreach ($kategoriList as $nama) {
            Kategori::create(['nama_kategori' => $nama]);
        }
    }
}
