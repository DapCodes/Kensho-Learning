<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ruangan = [];

        $jurusan = [
            'RPL' => 3,
            'TBSM' => 2,
            'TKRO' => 2,
        ];

        // Kelas X sampai XII
        foreach (['X', 'XI', 'XII'] as $kelas) {
            foreach ($jurusan as $namaJurusan => $jumlahKelas) {
                for ($i = 1; $i <= $jumlahKelas; $i++) {
                    $ruangan[] = [
                        'nama_kelas' => "$kelas $namaJurusan $i",
                        'jurusan' => $namaJurusan,
                    ];
                }
            }
        }

        DB::table('kelas')->insert($ruangan);
    }
}
