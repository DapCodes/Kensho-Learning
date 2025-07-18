<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesans'; // Nama tabel dari migration

    protected $fillable = [
        'nama_pengirim',
        'email_pengirim',
        'pesan',
    ];
}
