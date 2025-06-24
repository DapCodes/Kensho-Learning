<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'skor',
        'jumlah_benar',
        'jumlah_salah',
        'waktu_pengerjaan',
        'tanggal_ujian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
