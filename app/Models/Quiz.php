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

    /**
     * TAMBAHAN: Method untuk mengecek apakah quiz memiliki essay yang perlu dikoreksi
     */
    public function hasEssayNeedingGrading()
    {
        return $this->hasilUjian()
            ->whereHas('detail', function ($query) {
                $query->whereHas('soal', function ($subQuery) {
                    $subQuery->where('tipe', 'essay');
                })
                    ->where(function ($statusQuery) {
                        $statusQuery->where('status_jawaban', 'pending')
                            ->orWhere('bobot_diperoleh', 0);
                    });
            })
            ->exists();
    }

    /**
     * TAMBAHAN: Method untuk mengecek apakah user dapat mengakses quiz untuk koreksi
     */
    public function canBeGradedBy($userId)
    {
        return $this->user_id == $userId;
    }

    /**
     * TAMBAHAN: Scope untuk quiz yang dibuat oleh user tertentu
     */
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * TAMBAHAN: Scope untuk quiz yang memiliki essay pending
     */
    public function scopeWithPendingEssays($query)
    {
        return $query->whereHas('hasilUjian.detail', function ($subQuery) {
            $subQuery->whereHas('soal', function ($soalQuery) {
                $soalQuery->where('tipe', 'essay');
            })
                ->where(function ($statusQuery) {
                    $statusQuery->where('status_jawaban', 'pending')
                        ->orWhere('bobot_diperoleh', 0);
                });
        });
    }
}
