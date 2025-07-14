<?php

// ==============================================
// FILE: app/Models/HasilUjianDetail.php
// ==============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilUjianDetail extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian_details';

    protected $fillable = [
        'hasil_ujian_id',
        'soal_id',
        'jawaban_peserta',
        'status_jawaban',
        'bobot_soal',
        'bobot_diperoleh',
    ];

    protected $casts = [
        'bobot_soal' => 'integer',
        'bobot_diperoleh' => 'decimal:2', // Ubah ke decimal untuk mendukung nilai pecahan
    ];

    /**
     * Relasi ke model HasilUjian
     */
    public function hasilUjian(): BelongsTo
    {
        return $this->belongsTo(HasilUjian::class);
    }

    /**
     * Relasi ke model Soal
     */
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Scope untuk mencari detail berdasarkan hasil ujian
     */
    public function scopeByHasilUjian($query, $hasilUjianId)
    {
        return $query->where('hasil_ujian_id', $hasilUjianId);
    }

    /**
     * Scope untuk mencari detail berdasarkan status jawaban
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_jawaban', $status);
    }

    /**
     * Scope untuk jawaban yang benar
     */
    public function scopeBenar($query)
    {
        return $query->where('status_jawaban', 'benar');
    }

    /**
     * Scope untuk jawaban yang salah
     */
    public function scopeSalah($query)
    {
        return $query->where('status_jawaban', 'salah');
    }

    /**
     * Scope untuk jawaban yang sebagian benar
     */
    public function scopeSebagian($query)
    {
        return $query->where('status_jawaban', 'sebagian');
    }

    /**
     * Scope untuk jawaban yang pending (essay)
     */
    public function scopePending($query)
    {
        return $query->where('status_jawaban', 'pending');
    }

    /**
     * Scope untuk jawaban yang tidak dijawab
     */
    public function scopeTidakDijawab($query)
    {
        return $query->where('status_jawaban', 'tidak dijawab');
    }

    /**
     * Accessor untuk mendapatkan jawaban peserta dalam format yang mudah dibaca
     */
    public function getJawabanPesertaFormattedAttribute()
    {
        if (empty($this->jawaban_peserta)) {
            return 'Tidak dijawab';
        }

        // Jika jawaban berupa pilihan ganda yang dipisahkan koma (checkbox)
        if (strpos($this->jawaban_peserta, ',') !== false) {
            $jawaban = explode(',', $this->jawaban_peserta);

            return implode(', ', array_map('trim', $jawaban));
        }

        return $this->jawaban_peserta;
    }

    /**
     * Accessor untuk mendapatkan status jawaban dengan warna
     */
    public function getStatusJawabanBadgeAttribute()
    {
        switch ($this->status_jawaban) {
            case 'benar':
                return '<span class="badge bg-success">Benar</span>';
            case 'salah':
                return '<span class="badge bg-danger">Salah</span>';
            case 'sebagian':
                return '<span class="badge bg-warning">Sebagian Benar</span>';
            case 'pending':
                return '<span class="badge bg-info">Pending</span>';
            case 'tidak dijawab':
                return '<span class="badge bg-secondary">Tidak Dijawab</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }

    /**
     * Accessor untuk mendapatkan persentase bobot
     */
    public function getPersentaseBobotAttribute()
    {
        if ($this->bobot_soal == 0) {
            return 0;
        }

        return round(($this->bobot_diperoleh / $this->bobot_soal) * 100, 2);
    }

    /**
     * Method untuk mengecek apakah jawaban benar
     */
    public function isCorrect()
    {
        return $this->status_jawaban === 'benar';
    }

    /**
     * Method untuk mengecek apakah jawaban salah
     */
    public function isIncorrect()
    {
        return $this->status_jawaban === 'salah';
    }

    /**
     * Method untuk mengecek apakah jawaban sebagian benar
     */
    public function isPartiallyCorrect()
    {
        return $this->status_jawaban === 'sebagian';
    }

    /**
     * Method untuk mengecek apakah jawaban pending
     */
    public function isPending()
    {
        return $this->status_jawaban === 'pending';
    }

    /**
     * Method untuk mengecek apakah tidak dijawab
     */
    public function isNotAnswered()
    {
        return $this->status_jawaban === 'tidak dijawab';
    }
}
