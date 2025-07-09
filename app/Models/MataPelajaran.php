<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika nama model dan tabel tidak sesuai konvensi)
    protected $table = 'mata_pelajarans';

    // Kolom-kolom yang boleh diisi
    protected $fillable = [
        'nama_mapel',
        'deskripsi',
    ];

    /**
     * Relasi ke Quiz (One to Many)
     * Satu mata pelajaran bisa memiliki banyak quiz.
     */
    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'mata_pelajaran_id');
    }
}
