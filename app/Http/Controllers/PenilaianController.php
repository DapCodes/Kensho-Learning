<?php

namespace App\Http\Controllers;

use App\Exports\DataNilaiExport;
use App\Exports\DataPengerjaanSiswaExport;
use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use Barryvdh\DomPDF\Facade\Pdf;
// Tambahkan import ini di bagian atas controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianController extends Controller
{
    /**
     * Show the form for grading essay questions for a specific hasil ujian.
     */
    public function show($id)
    {
        // Cek apakah user memiliki akses ke quiz ini
        $hasilUjian = HasilUjian::with(['user', 'quiz'])
            ->whereHas('quiz', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        // Ambil semua essay details (baik yang sudah dinilai maupun belum)
        $allEssayDetails = HasilUjianDetail::with(['soal'])
            ->where('hasil_ujian_id', $id)
            ->whereHas('soal', function ($query) {
                $query->where('tipe', 'essay');
            })
            ->get();

        // Pisahkan essay yang belum dinilai dan yang sudah dinilai
        $essayDetails = collect();
        $gradedEssayDetails = collect();

        foreach ($allEssayDetails as $detail) {
            // Essay dianggap belum dinilai jika:
            // 1. Status masih pending, ATAU
            // 2. Status bukan pending tapi bobot_diperoleh masih null/0 dan ada jawaban peserta
            if ($detail->status_jawaban === 'pending') {
                $essayDetails->push($detail);
            } else {
                $gradedEssayDetails->push($detail);
            }
        }

        return view('backend.penilaian.show', compact('hasilUjian', 'essayDetails', 'gradedEssayDetails'));
    }

    /**
     * Update grades for essay questions
     */
    public function updateGrade(Request $request, $id)
    {
        $hasilUjian = HasilUjian::with(['quiz'])
            ->whereHas('quiz', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|numeric|min:0', // Sudah benar, min:0 membolehkan nilai 0
        ]);

        DB::beginTransaction();
        try {
            $updatedCount = 0;

            foreach ($request->grades as $detailId => $grade) {
                $detail = HasilUjianDetail::with(['soal'])
                    ->where('hasil_ujian_id', $id)
                    ->where('id', $detailId)
                    ->whereHas('soal', function ($query) {
                        $query->where('tipe', 'essay');
                    })
                    ->first();

                if ($detail) {
                    $maxGrade = $detail->bobot_soal;

                    // Pastikan grade adalah numeric dan tidak null
                    $grade = is_numeric($grade) ? (float) $grade : 0;

                    // Batasi nilai sesuai dengan bobot maksimal
                    $finalGrade = min($grade, $maxGrade);

                    // Pastikan nilai tidak negatif (sebagai safety net)
                    $finalGrade = max(0, $finalGrade);

                    // Tentukan status jawaban berdasarkan nilai
                    $statusJawaban = 'salah'; // default untuk nilai 0

                    if ($finalGrade > 0) {
                        if ($finalGrade == $maxGrade) {
                            $statusJawaban = 'benar';
                        } else {
                            $statusJawaban = 'sebagian'; // untuk nilai parsial
                        }
                    }
                    // Note: Jika $finalGrade == 0, statusJawaban tetap 'salah' (sudah benar)

                    // Update detail
                    $detail->update([
                        'bobot_diperoleh' => $finalGrade,
                        'status_jawaban' => $statusJawaban,
                    ]);

                    $updatedCount++;
                }
            }

            // Recalculate total score
            $this->recalculateScore($hasilUjian);

            DB::commit();

            return redirect()->route('penilaian.show', $id)
                ->with('success', "Penilaian berhasil disimpan untuk {$updatedCount} essay!");

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Recalculate the total score for a quiz result
     */
    private function recalculateScore(HasilUjian $hasilUjian)
    {
        $details = $hasilUjian->detail;

        $totalBobotDiperoleh = $details->sum('bobot_diperoleh');
        $totalBobotMaksimal = $details->sum('bobot_soal');

        // Hitung jumlah benar/salah dengan lebih tepat
        $jumlahBenar = $details->where('status_jawaban', 'benar')->count();
        $jumlahSalah = $details->whereIn('status_jawaban', ['salah', 'tidak dijawab'])->count();
        $jumlahSebagian = $details->where('status_jawaban', 'sebagian')->count();

        // Calculate percentage score
        $skor = $totalBobotMaksimal > 0 ? ($totalBobotDiperoleh / $totalBobotMaksimal) * 100 : 0;

        $hasilUjian->update([
            'skor' => round($skor, 2),
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah,
            'total_bobot' => $totalBobotMaksimal,
            'bobot_diperoleh' => $totalBobotDiperoleh,
        ]);
    }

    /**
     * Reset grading for essay questions
     */
    public function resetGrading($id)
    {
        $hasilUjian = HasilUjian::with(['quiz'])
            ->whereHas('quiz', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            // Reset semua essay ke status pending
            HasilUjianDetail::where('hasil_ujian_id', $id)
                ->whereHas('soal', function ($query) {
                    $query->where('tipe', 'essay');
                })
                ->update([
                    'bobot_diperoleh' => 0,
                    'status_jawaban' => 'pending',
                ]);

            // Recalculate score
            $this->recalculateScore($hasilUjian);

            DB::commit();

            return redirect()->route('penilaian.show', $id)
                ->with('success', 'Penilaian essay telah direset!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat reset penilaian: '.$e->getMessage());
        }
    }

    /**
     * Show data nilai page
     */
    public function dataNilai(Request $request)
    {
        $exportType = $request->input('export');

        // Ambil semua hasil ujian dari quiz yang dibuat oleh user saat ini
        $hasilUjians = HasilUjian::with(['user', 'quiz'])
            ->whereHas('quiz', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('tanggal_ujian', 'desc')
            ->get();

        // Export jika diminta
        if ($exportType === 'excel') {
            return Excel::download(
                new DataNilaiExport($hasilUjians),
                'laporan-data-nilai-peserta.xlsx'
            );
        }

        if ($exportType === 'pdf') {
            $pdf = Pdf::loadView('pdf.dataNilai', ['hasilUjians' => $hasilUjians]);

            return $pdf->download('laporan-data-nilai-peserta.pdf');
        }

        return view('backend.penilaian.data_nilai', compact('hasilUjians'));
    }

    /**
     * Show detail hasil ujian
     */
    public function detail($id, Request $request)
    {
        $exportType = $request->input('export');

        // Get exam result with quiz and related data
        $hasil = HasilUjian::with(['quiz', 'detail.soal', 'user'])
            ->whereHas('quiz', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        // Export jika diminta
        if ($exportType === 'excel') {
            $fileName = 'Pengerjaan_'.str_replace(' ', '_', $hasil->user->name).'_'.
                    str_replace(' ', '_', $hasil->quiz->judul).'_'.
                    date('Y-m-d_H-i-s').'.xlsx';

            return Excel::download(new DataPengerjaanSiswaExport($id), $fileName);
        }

        if ($exportType === 'pdf') {
            $fileName = 'Pengerjaan_'.str_replace(' ', '_', $hasil->user->name).'_'.
                    str_replace(' ', '_', $hasil->quiz->judul).'_'.
                    date('Y-m-d_H-i-s').'.pdf';

            $pdf = Pdf::loadView('pdf.detailPengerjaan', compact('hasil'));

            return $pdf->download($fileName);
        }

        // Calculate ranking based on weighted score
        $ranking = HasilUjian::where('quiz_id', $hasil->quiz_id)
            ->where(function ($query) use ($hasil) {
                $query->where('bobot_diperoleh', '>', $hasil->bobot_diperoleh)
                    ->orWhere(function ($subQuery) use ($hasil) {
                        $subQuery->where('bobot_diperoleh', '=', $hasil->bobot_diperoleh)
                            ->where('waktu_pengerjaan', '<', $hasil->waktu_pengerjaan);
                    });
            })
            ->count() + 1;

        // Get total participants for the same quiz
        $total_peserta = HasilUjian::where('quiz_id', $hasil->quiz_id)->count();

        // Get top 10 performers based on weighted score and time
        $top_performers = HasilUjian::with('user')
            ->where('quiz_id', $hasil->quiz_id)
            ->orderBy('bobot_diperoleh', 'desc')
            ->orderBy('waktu_pengerjaan', 'asc')
            ->take(10)
            ->get();

        $hasil_detail = $hasil->detail()->with('soal')->get();

        return view('backend.penilaian.detail', compact(
            'hasil',
            'ranking',
            'total_peserta',
            'top_performers',
            'hasil_detail'
        ));
    }

    /**
     * Debug method to check essay status
     */
    public function debugEssayStatus($id)
    {
        $details = HasilUjianDetail::with(['soal'])
            ->where('hasil_ujian_id', $id)
            ->whereHas('soal', function ($query) {
                $query->where('tipe', 'essay');
            })
            ->get();

        $debugInfo = [];
        foreach ($details as $detail) {
            $debugInfo[] = [
                'id' => $detail->id,
                'bobot_diperoleh' => $detail->bobot_diperoleh,
                'bobot_soal' => $detail->bobot_soal,
                'status_jawaban' => $detail->status_jawaban,
                'jawaban_peserta' => ! empty($detail->jawaban_peserta) ? 'Ada' : 'Kosong',
                'type_bobot' => gettype($detail->bobot_diperoleh),
            ];
        }

        return response()->json($debugInfo);
    }
}
