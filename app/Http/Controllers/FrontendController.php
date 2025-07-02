<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Quiz;

class FrontendController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('status', 'Umum')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.index', compact('quizzes'));
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
