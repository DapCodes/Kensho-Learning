<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Kategori;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
public function index(Request $request)
{
    $query = Quiz::where('status', 'Umum')->orderBy('created_at', 'desc');

    if ($request->filled('kategori_id')) {
        $query->where('kategori_id', $request->kategori_id);
    }

    $quizzes = $query->get();
    $kategori = Kategori::all();

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

        return redirect()->back()->with('error', 'Kode quiz tidak ditemukan.');
    }

    public function detail($id)
    {
        $quiz = Quiz::findOrFail($id);

        return view('frontend.detail_quiz', compact('quiz'));
    }
}
