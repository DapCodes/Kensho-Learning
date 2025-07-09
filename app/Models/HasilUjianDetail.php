<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjianDetail extends Model
{
    protected $table = 'hasil_ujian_detail';

    protected $fillable = [
        'hasil_ujian_id',
        'soal_id',
        'jawaban_peserta',
        'status_jawaban',
    ];

    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
