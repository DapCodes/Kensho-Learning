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
        'user_id',
        'tanggal_buat',
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

    public function peringkat()
    {
        return $this->hasMany(Peringkat::class);
    }

    public function histori()
    {
        return $this->hasMany(HistoriUser::class);
    }
}
