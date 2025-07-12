<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = [
        'quiz_id',
        'tipe',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'pilihan_f',
        'pilihan_g',
        'pilihan_h',
        'pilihan_i',
        'pilihan_j',
        'jawaban_benar',
        'bobot',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
