<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'judul_quiz',
        'deskripsi',
        'kode_quiz',
        'waktu_menit',
        'kategori_id',
        'mata_pelajaran_id',
        'user_id',
        'status_aktivasi',
        'tanggal_buat',
        'pengulangan_pekerjaan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
