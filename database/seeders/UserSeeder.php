<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '2',
        ]);

        \App\Models\User::create([
            'name' => 'Pa Ute',
            'email' => 'paute@gmail.com',
            'kelas_id' => 2,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Pa Chandra',
            'email' => 'pachandra@gmail.com',
            'kelas_id' => 2,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Pa Mulki',
            'email' => 'pamulki@gmail.com',
            'kelas_id' => 2,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Daffa Ramadhan',
            'email' => 'daffa@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Rio Oktora',
            'email' => 'rio@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Ani Suryani',
            'email' => 'ani@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Danuar Maulana',
            'email' => 'danu@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('rahasia'),
            'isAdmin' => '0',
        ]);
    }
}
