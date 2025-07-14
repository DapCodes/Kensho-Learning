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
            'password' => bcrypt('admin123'),
            'isAdmin' => '2',
        ]);

        \App\Models\User::create([
            'name' => 'Pa Ute',
            'email' => 'paute@gmail.com',
            'kelas_id' => 2,
            'password' => bcrypt('12345678'),
            'isAdmin' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Daffa Ramadhan',
            'email' => 'daffa@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Dhea Febrianti',
            'email' => 'dhea@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Rio Oktora',
            'email' => 'rio@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Ani Suryani',
            'email' => 'ani@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);

        \App\Models\User::create([
            'name' => 'Danu Suryani',
            'email' => 'danu@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);
    }
}
