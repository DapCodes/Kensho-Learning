<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\Kategori;
use App\Models\Quiz;
use Auth;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::where('status', 'Umum')
            ->where('status_aktivasi', 'aktif')
            ->orderBy('created_at', 'desc');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $quizzes = $query->get();
        $kategori = Kategori::whereHas('quiz', function ($query) {
            $query->where('status_aktivasi', 'aktif')
                ->where('status', 'umum');
        })->get();

        return view('frontend.index', compact('quizzes', 'kategori'));
    }

    public function checkKode(Request $request)
    {
        $request->validate([
            'kode_quiz' => 'required|string',
        ]);

        $quiz = Quiz::where('kode_quiz', $request->kode_quiz)->first();

        if ($quiz) {
            return redirect()->route('quiz.detail', $quiz->id);
        }

        return redirect()->back()->with('error', 'Kode quiz tidak ditemukan!');
    }

    public function detail($id)
    {
        $quiz = Quiz::findOrFail($id);

        if ($quiz->status_aktivasi === 'non aktif') {
            return redirect()->back()->with('error', 'Quiz sedang tidak dapat dikerjakan');
        }

        // Cek apakah pengulangan tidak diperbolehkan
        if ($quiz->pengulangan_pekerjaan === 'Tidak') {
            $sudahMengerjakan = HasilUjian::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->exists();

            if ($sudahMengerjakan) {
                return redirect()->back()->with('error', 'Anda sudah mengerjakan quiz ini sebelumnya');
            }
        }

        return view('frontend.detail_quiz', compact('quiz'));
    }
}
