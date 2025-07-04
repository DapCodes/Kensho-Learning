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
            'password' => bcrypt('admin123'),
            'isAdmin' => 1,
        ]);

        \App\Models\User::create([
            'name' => 'Daffa Ramadhan',
            'email' => 'daffa@gmail.com',
            'password' => bcrypt('12345678'),
            'isAdmin' => 0,
        ]);

        \App\Models\User::create([
            'name' => 'Dhea Febrianti',
            'email' => 'dhea@gmail.com',
            'password' => bcrypt('12345678'),
            'isAdmin' => 0,
        ]);
    }
}
