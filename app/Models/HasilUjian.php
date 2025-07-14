<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujians';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'skor',
        'jumlah_benar',
        'jumlah_salah',
        'total_bobot',
        'bobot_diperoleh',
        'waktu_pengerjaan',
        'tanggal_ujian',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
        'waktu_pengerjaan' => 'decimal:2',
        'tanggal_ujian' => 'date',
        'jumlah_benar' => 'integer',
        'jumlah_salah' => 'integer',
        'total_bobot' => 'integer',
        'bobot_diperoleh' => 'integer',
    ];

    /**
     * Relasi ke model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Quiz
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relasi ke model HasilUjianDetail
     */
    public function detail(): HasMany
    {
        return $this->hasMany(HasilUjianDetail::class);
    }

    /**
     * Scope untuk mencari hasil ujian berdasarkan quiz
     */
    public function scopeByQuiz($query, $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }

    /**
     * Scope untuk mencari hasil ujian berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk mengurutkan berdasarkan ranking (bobot tertinggi, waktu tercepat)
     */
    public function scopeRanking($query)
    {
        return $query->orderBy('bobot_diperoleh', 'desc')
            ->orderBy('waktu_pengerjaan', 'asc');
    }

    /**
     * Accessor untuk mendapatkan persentase skor
     */
    public function getPersentaseSkorAttribute()
    {
        return $this->skor.'%';
    }

    /**
     * Accessor untuk mendapatkan waktu pengerjaan dalam format yang mudah dibaca
     */
    public function getWaktuPengerjaanFormattedAttribute()
    {
        $menit = floor($this->waktu_pengerjaan);
        $detik = round(($this->waktu_pengerjaan - $menit) * 60);

        return $menit.' menit '.$detik.' detik';
    }

    /**
     * Accessor untuk mendapatkan status lulus/tidak lulus
     * (Anda bisa menyesuaikan batas kelulusan sesuai kebutuhan)
     */
    public function getStatusKelulusanAttribute()
    {
        $batasLulus = 60; // Batas kelulusan 60%

        return $this->skor >= $batasLulus ? 'Lulus' : 'Tidak Lulus';
    }

    /**
     * Method untuk mendapatkan ranking peserta dalam quiz tertentu
     */
    public function getRanking()
    {
        return self::where('quiz_id', $this->quiz_id)
            ->where(function ($query) {
                $query->where('bobot_diperoleh', '>', $this->bobot_diperoleh)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('bobot_diperoleh', '=', $this->bobot_diperoleh)
                            ->where('waktu_pengerjaan', '<', $this->waktu_pengerjaan);
                    });
            })
            ->count() + 1;
    }

    /**
     * Method untuk mendapatkan total peserta dalam quiz
     */
    public function getTotalPeserta()
    {
        return self::where('quiz_id', $this->quiz_id)->count();
    }

    /**
     * Method untuk mendapatkan top performers dalam quiz
     */
    public static function getTopPerformers($quizId, $limit = 10)
    {
        return self::with('user')
            ->where('quiz_id', $quizId)
            ->ranking()
            ->take($limit)
            ->get();
    }
}
