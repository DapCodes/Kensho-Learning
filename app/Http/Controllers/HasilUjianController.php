<?php

namespace App\Http\Controllers;

use App\Exports\DataNilaiExport;
use App\Models\HasilUjian;
use App\Models\Quiz;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HasilUjianController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->id;

        // Validasi jika max_skor < min_skor
        if ($request->filled('min_skor') && $request->filled('max_skor')) {
            if ($request->max_skor < $request->min_skor) {
                return redirect()->route('histori-pengerjaan')
                    ->with('error', 'Skor maksimum tidak boleh lebih kecil dari skor minimum.');
            }
        }

        $query = HasilUjian::with(['quiz', 'user'])
            ->where('user_id', $user);

        // Cek apakah ada filter
        $adaFilter = $request->filled('min_skor') || $request->filled('max_skor');

        if ($request->filled('min_skor')) {
            $query->where('skor', '>=', $request->min_skor);
        }

        if ($request->filled('max_skor')) {
            $query->where('skor', '<=', $request->max_skor);
        }

        // Jika ada filter → sembunyikan quiz private
        if ($adaFilter) {
            $query->whereHas('quiz', function ($q) {
                $q->where('status', '!=', 'private');
            });
        }

        $histori = $query->latest()->get();

        return view('frontend.histori_pengerjaan', compact('histori'));
    }



    /**
     * Export semua data to Excel
     */
    public function exportExcel()
    {
        // Ambil data hasil ujian milik user yang sedang login dengan quiz status 'Umum'
        $hasilUjians = HasilUjian::with(['quiz', 'user'])
            ->where('user_id', Auth::id())
            ->whereHas('quiz', function ($query) {
                $query->where('status', 'Umum');
            })
            ->latest()
            ->get();

        // Generate filename dengan timestamp
        $filename = 'laporan_nilai_user_'.date('Y-m-d_H-i-s').'.xlsx';

        return Excel::download(new DataNilaiExport($hasilUjians), $filename);
    }

    /**
     * Export semua data to PDF
     */
    public function exportPDF()
    {
        // Ambil data hasil ujian milik user yang sedang login dengan quiz status 'Umum'
        $hasilUjians = HasilUjian::with(['quiz', 'user'])
            ->where('user_id', Auth::id())
            ->whereHas('quiz', function ($query) {
                $query->where('status', 'Umum');
            })
            ->latest()
            ->get();

        // Generate filename dengan timestamp
        $filename = 'laporan_nilai_user_'.date('Y-m-d_H-i-s').'.pdf';

        // Load view dan generate PDF
        $pdf = Pdf::loadView('exports.data_nilai_pdf', compact('hasilUjians'));

        // Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }
}
