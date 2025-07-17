<?php

namespace App\Http\Controllers;

use App\Exports\QuizExport;
use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use App\Models\Kategori;
use App\Models\MataPelajaran;
use App\Models\Quiz;
use App\Models\Soal;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin === '1') {
            $quizzes = Quiz::with(['user', 'soals'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $quizzes = Quiz::with('soals')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Handle export requests
        if ($request->has('export') && $request->has('quiz_id')) {
            $quizId = $request->get('quiz_id');
            $quiz = Quiz::with('soals')->findOrFail($quizId);

            // Check if user has permission to export this quiz
            if ($user->isAdmin === '1' && $quiz->user_id !== auth()->id()) {
                abort(403, 'Unauthorized to export this quiz');
            }

            $exportType = $request->get('export');

            if ($exportType === 'excel') {
                return Excel::download(new QuizExport($quiz), 'quiz_'.$quiz->kode_quiz.'.xlsx');
            } elseif ($exportType === 'pdf') {
                return $this->exportToPdf($quiz);
            }
        }

        return view('backend.quiz.index', compact('quizzes'));
    }

    private function exportToPdf($quiz)
    {
        $pdf = Pdf::loadView('backend.quiz.export-pdf', compact('quiz'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('quiz_'.$quiz->kode_quiz.'.pdf');
    }

    public function toggleAktivasi($id)
    {
        $quiz = Quiz::findOrFail($id);

        // Toggle status
        $quiz->status_aktivasi = $quiz->status_aktivasi === 'aktif' ? 'non aktif' : 'aktif';
        $quiz->save();

        return redirect()->back()->with('success', 'Status aktivasi kuis berhasil diperbarui.');
    }

    public function create()
    {
        $categories = Kategori::all();
        $mataPelajaran = MataPelajaran::all();

        return view('backend.quiz.create', compact('categories', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:Privat,Umum',
            'duration' => 'required|integer|min:1|max:300',
            'categories' => 'required',
            'mapel' => 'required',
            'num_questions' => 'required|integer|min:1|max:50',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string|max:1000',
            'questions.*.type' => 'required|in:pilihan_ganda,essay,benar_salah,checkbox',
            'questions.*.weight' => 'required|integer|min:1|max:100',
            'aktivasi' => 'required|in:aktif,non aktif',
            'pengulangan' => 'required|in:Boleh,Tidak', // Tambahkan validasi untuk pengulangan
            // Multiple choice fields
            'questions.*.option_a' => 'nullable|string|max:255',
            'questions.*.option_b' => 'nullable|string|max:255',
            'questions.*.option_c' => 'nullable|string|max:255',
            'questions.*.option_d' => 'nullable|string|max:255',
            'questions.*.option_e' => 'nullable|string|max:255',
            'questions.*.option_f' => 'nullable|string|max:255',
            'questions.*.option_g' => 'nullable|string|max:255',
            'questions.*.option_h' => 'nullable|string|max:255',
            'questions.*.option_i' => 'nullable|string|max:255',
            'questions.*.option_j' => 'nullable|string|max:255',
            'questions.*.correct_answer' => 'nullable|string',
            // Checkbox fields
            'questions.*.checkbox_options' => 'nullable|array',
            'questions.*.checkbox_options.*' => 'nullable|string|max:255',
            'questions.*.checkbox_correct' => 'nullable|array',
        ], [
            'quiz_title.required' => 'Judul quiz wajib diisi.',
            'quiz_title.max' => 'Judul quiz maksimal 255 karakter.',
            'description.max' => 'Deskripsi quiz maksimal 1000 karakter.',
            'visibility.required' => 'Status visibilitas quiz wajib dipilih.',
            'visibility.in' => 'Status visibilitas harus Privat atau Umum.',
            'duration.required' => 'Durasi quiz wajib diisi.',
            'duration.integer' => 'Durasi harus berupa angka.',
            'duration.min' => 'Durasi minimal 1 menit.',
            'duration.max' => 'Durasi maksimal 300 menit.',
            'num_questions.required' => 'Jumlah soal wajib diisi.',
            'num_questions.integer' => 'Jumlah soal harus berupa angka.',
            'num_questions.min' => 'Minimal 1 soal.',
            'num_questions.max' => 'Maksimal 50 soal.',
            'questions.required' => 'Soal quiz wajib diisi.',
            'aktivasi.required' => 'Status aktivasi wajib dipilih.',
            'aktivasi.in' => 'Status aktivasi harus aktif atau non aktif.',
            'pengulangan.required' => 'Pengulangan pekerjaan wajib dipilih.',
            'pengulangan.in' => 'Pengulangan pekerjaan harus Boleh atau Tidak.',
            'questions.*.text.required' => 'Teks soal wajib diisi.',
            'questions.*.text.max' => 'Teks soal maksimal 1000 karakter.',
            'questions.*.type.required' => 'Tipe soal wajib dipilih.',
            'questions.*.type.in' => 'Tipe soal tidak valid.',
            'questions.*.weight.required' => 'Bobot soal wajib diisi.',
            'questions.*.weight.integer' => 'Bobot soal harus berupa angka.',
            'questions.*.weight.min' => 'Bobot soal minimal 1.',
            'questions.*.weight.max' => 'Bobot soal maksimal 100.',
            'questions.*.option_a.max' => 'Pilihan A maksimal 255 karakter.',
            'questions.*.option_b.max' => 'Pilihan B maksimal 255 karakter.',
            'questions.*.option_c.max' => 'Pilihan C maksimal 255 karakter.',
            'questions.*.option_d.max' => 'Pilihan D maksimal 255 karakter.',
            'questions.*.option_e.max' => 'Pilihan E maksimal 255 karakter.',
            'questions.*.option_f.max' => 'Pilihan F maksimal 255 karakter.',
            'questions.*.option_g.max' => 'Pilihan G maksimal 255 karakter.',
            'questions.*.option_h.max' => 'Pilihan H maksimal 255 karakter.',
            'questions.*.option_i.max' => 'Pilihan I maksimal 255 karakter.',
            'questions.*.option_j.max' => 'Pilihan J maksimal 255 karakter.',
            'questions.*.checkbox_options.*.max' => 'Opsi checkbox maksimal 255 karakter.',
        ]);

        // Custom validation for question types
        foreach ($validatedData['questions'] as $index => $question) {
            $questionType = $question['type'];
            $questionIndex = $index + 1;

            if ($questionType === 'pilihan_ganda') {
                if (empty($question['option_a']) || empty($question['option_b']) ||
                    empty($question['option_c']) || empty($question['option_d'])) {
                    return back()->withErrors([
                        'questions' => "Semua pilihan (A, B, C, D) wajib diisi untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
                if (empty($question['correct_answer']) || ! in_array($question['correct_answer'], ['A', 'B', 'C', 'D'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
            } elseif ($questionType === 'benar_salah') {
                if (empty($question['correct_answer']) || ! in_array($question['correct_answer'], ['Benar', 'Salah'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal benar/salah nomor {$questionIndex}.",
                    ])->withInput();
                }
            } elseif ($questionType === 'checkbox') {
                if (empty($question['checkbox_options']) || count($question['checkbox_options']) < 2) {
                    return back()->withErrors([
                        'questions' => "Minimal 2 opsi wajib diisi untuk soal checkbox nomor {$questionIndex}.",
                    ])->withInput();
                }
                if (empty($question['checkbox_correct']) || count($question['checkbox_correct']) < 1) {
                    return back()->withErrors([
                        'questions' => "Minimal 1 jawaban benar wajib dipilih untuk soal checkbox nomor {$questionIndex}.",
                    ])->withInput();
                }
            }
        }

        if (count($validatedData['questions']) != $validatedData['num_questions']) {
            return back()->withErrors(['questions' => 'Jumlah soal tidak sesuai dengan yang diinputkan.'])
                ->withInput();
        }

        try {
            $kodeQuiz = $this->generateUniqueQuizCode();

            DB::beginTransaction();

            $quiz = Quiz::create([
                'judul_quiz' => $validatedData['quiz_title'],
                'deskripsi' => $validatedData['description'] ?? '',
                'kode_quiz' => $kodeQuiz,
                'waktu_menit' => $validatedData['duration'],
                'kategori_id' => $validatedData['categories'],
                'mata_pelajaran_id' => $validatedData['mapel'],
                'user_id' => auth()->id(),
                'status' => $validatedData['visibility'],
                'status_aktivasi' => $validatedData['aktivasi'],
                'pengulangan_pekerjaan' => $validatedData['pengulangan'], // Tambahkan ini
                'tanggal_buat' => Carbon::now(),
            ]);

            foreach ($validatedData['questions'] as $questionData) {
                $soalData = [
                    'quiz_id' => $quiz->id,
                    'tipe' => $questionData['type'],
                    'pertanyaan' => $questionData['text'],
                    'bobot' => $questionData['weight'],
                    'pilihan_a' => null,
                    'pilihan_b' => null,
                    'pilihan_c' => null,
                    'pilihan_d' => null,
                    'pilihan_e' => null,
                    'pilihan_f' => null,
                    'pilihan_g' => null,
                    'pilihan_h' => null,
                    'pilihan_i' => null,
                    'pilihan_j' => null,
                    'jawaban_benar' => null,
                ];

                // Handle different question types
                switch ($questionData['type']) {
                    case 'pilihan_ganda':
                        $soalData['pilihan_a'] = $questionData['option_a'] ?? null;
                        $soalData['pilihan_b'] = $questionData['option_b'] ?? null;
                        $soalData['pilihan_c'] = $questionData['option_c'] ?? null;
                        $soalData['pilihan_d'] = $questionData['option_d'] ?? null;
                        $soalData['jawaban_benar'] = $questionData['correct_answer'];
                        break;

                    case 'essay':
                        // For essay, we might store model answer or keep it null for manual grading
                        $soalData['jawaban_benar'] = $questionData['correct_answer'] ?? null;
                        break;

                    case 'benar_salah':
                        $soalData['jawaban_benar'] = $questionData['correct_answer'];
                        break;

                    case 'checkbox':
                        $checkboxOptions = $questionData['checkbox_options'];

                        $optionLetters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];

                        foreach ($optionLetters as $index => $letter) {
                            if (isset($checkboxOptions[$index])) {
                                $soalData['pilihan_'.$letter] = $checkboxOptions[$index];
                            }
                        }

                        // Store correct answers as comma-separated string
                        $correctAnswers = $questionData['checkbox_correct'];
                        $soalData['jawaban_benar'] = implode(',', $correctAnswers);
                        break;
                }

                Soal::create($soalData);
            }

            DB::commit();

            $statusMessage = $validatedData['visibility'] === 'Umum' ? 'dibuat sebagai umum' : 'dibuat sebagai privat';

            return redirect()->route('quiz.index')
                ->with('success', "Quiz berhasil {$statusMessage} dengan kode: {$kodeQuiz}");

        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('Error creating quiz: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat quiz. Silakan coba lagi.'])
                ->withInput();
        }
    }

    private function generateUniqueQuizCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Quiz::where('kode_quiz', $code)->exists());

        return $code;
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('soals');

        return view('backend.quiz.show', compact('quiz'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with(['soals', 'kategori', 'mataPelajaran'])->findOrFail($id);

        // Validasi ownership
        if ($quiz->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get categories and mata pelajaran
        $categories = \App\Models\Kategori::all();
        $mataPelajaran = \App\Models\MataPelajaran::all();

        // Process soal data untuk JavaScript
        $processedSoals = $quiz->soals               // Collection asli
            ->values()                               // RESET key jadi 0,1,2,…
            ->map(function ($soal) {
                $soalData = $soal->toArray();

                // Tambahan khusus tipe checkbox (kode Anda tadi)
                if ($soal->tipe === 'checkbox') {
                    $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
                    $soalData['checkbox_options'] = collect($letters)
                        ->map(fn ($l) => $soal->{'pilihan_'.$l})
                        ->filter()
                        ->values()
                        ->toArray();

                    $soalData['checkbox_correct'] = $soal->jawaban_benar
                        ? explode(',', $soal->jawaban_benar)
                        : [];
                }

                return $soalData;
            })
            ->toArray();

        return view('backend.quiz.edit', compact(
            'quiz', 'categories', 'mataPelajaran'
        ))->with('processedSoals', $processedSoals);

    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::with('soals')->findOrFail($id);

        // Validasi ownership
        if ($quiz->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'judul_quiz' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:Privat,Umum',
            'pengulangan' => 'required|in:Boleh,Tidak',
            'waktu_menit' => 'required|integer|min:1|max:300',
            'categories' => 'required|exists:kategoris,id',
            'mapel' => 'required|exists:mata_pelajarans,id',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:soals,id',
            'questions.*.pertanyaan' => 'required|string|max:1000',
            'questions.*.type' => 'required|in:pilihan_ganda,essay,benar_salah,checkbox',
            'questions.*.weight' => 'required|integer|min:1|max:100',
            // Multiple choice fields
            'questions.*.pilihan_a' => 'nullable|string|max:255',
            'questions.*.pilihan_b' => 'nullable|string|max:255',
            'questions.*.pilihan_c' => 'nullable|string|max:255',
            'questions.*.pilihan_d' => 'nullable|string|max:255',
            'questions.*.pilihan_e' => 'nullable|string|max:255',
            'questions.*.pilihan_f' => 'nullable|string|max:255',
            'questions.*.pilihan_g' => 'nullable|string|max:255',
            'questions.*.pilihan_h' => 'nullable|string|max:255',
            'questions.*.pilihan_i' => 'nullable|string|max:255',
            'questions.*.pilihan_j' => 'nullable|string|max:255',
            'questions.*.jawaban_benar' => 'nullable|string',
            // Checkbox fields
            'questions.*.checkbox_options' => 'nullable|array',
            'questions.*.checkbox_options.*' => 'nullable|string|max:255',
            'questions.*.checkbox_correct' => 'nullable|array',
        ], [
            'judul_quiz.required' => 'Judul quiz wajib diisi.',
            'judul_quiz.max' => 'Judul quiz maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi quiz maksimal 1000 karakter.',
            'status.required' => 'Status visibilitas quiz wajib dipilih.',
            'status.in' => 'Status visibilitas harus Privat atau Umum.',
            'pengulangan.required' => 'Status pengulangan quiz wajib dipilih.',
            'pengulangan.in' => 'Status pengulangan harus Boleh atau Tidak.',
            'waktu_menit.required' => 'Durasi quiz wajib diisi.',
            'waktu_menit.integer' => 'Durasi harus berupa angka.',
            'waktu_menit.min' => 'Durasi minimal 1 menit.',
            'waktu_menit.max' => 'Durasi maksimal 300 menit.',
            'categories.required' => 'Kategori quiz wajib dipilih.',
            'categories.exists' => 'Kategori yang dipilih tidak valid.',
            'mapel.required' => 'Mata pelajaran quiz wajib dipilih.',
            'mapel.exists' => 'Mata pelajaran yang dipilih tidak valid.',
            'questions.required' => 'Soal quiz wajib diisi.',
            'questions.min' => 'Minimal harus ada 1 soal.',
            'questions.*.pertanyaan.required' => 'Teks soal wajib diisi.',
            'questions.*.pertanyaan.max' => 'Teks soal maksimal 1000 karakter.',
            'questions.*.type.required' => 'Tipe soal wajib dipilih.',
            'questions.*.type.in' => 'Tipe soal tidak valid.',
            'questions.*.weight.required' => 'Bobot soal wajib diisi.',
            'questions.*.weight.integer' => 'Bobot soal harus berupa angka.',
            'questions.*.weight.min' => 'Bobot soal minimal 1.',
            'questions.*.weight.max' => 'Bobot soal maksimal 100.',
            'questions.*.pilihan_a.max' => 'Pilihan A maksimal 255 karakter.',
            'questions.*.pilihan_b.max' => 'Pilihan B maksimal 255 karakter.',
            'questions.*.pilihan_c.max' => 'Pilihan C maksimal 255 karakter.',
            'questions.*.pilihan_d.max' => 'Pilihan D maksimal 255 karakter.',
            'questions.*.pilihan_e.max' => 'Pilihan E maksimal 255 karakter.',
            'questions.*.pilihan_f.max' => 'Pilihan F maksimal 255 karakter.',
            'questions.*.pilihan_g.max' => 'Pilihan G maksimal 255 karakter.',
            'questions.*.pilihan_h.max' => 'Pilihan H maksimal 255 karakter.',
            'questions.*.pilihan_i.max' => 'Pilihan I maksimal 255 karakter.',
            'questions.*.pilihan_j.max' => 'Pilihan J maksimal 255 karakter.',
            'questions.*.checkbox_options.*.max' => 'Opsi checkbox maksimal 255 karakter.',
        ]);

        // Custom validation for question types
        foreach ($validatedData['questions'] as $index => $question) {
            $questionType = $question['type'];
            $questionIndex = $index + 1;

            if ($questionType === 'pilihan_ganda') {
                if (empty($question['pilihan_a']) || empty($question['pilihan_b']) ||
                    empty($question['pilihan_c']) || empty($question['pilihan_d'])) {
                    return back()->withErrors([
                        'questions' => "Semua pilihan (A, B, C, D) wajib diisi untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
                if (empty($question['jawaban_benar']) || ! in_array($question['jawaban_benar'], ['A', 'B', 'C', 'D'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
            } elseif ($questionType === 'benar_salah') {
                if (empty($question['jawaban_benar']) || ! in_array($question['jawaban_benar'], ['Benar', 'Salah'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal benar/salah nomor {$questionIndex}.",
                    ])->withInput();
                }
            } elseif ($questionType === 'checkbox') {
                if (empty($question['checkbox_options']) || count($question['checkbox_options']) < 2) {
                    return back()->withErrors([
                        'questions' => "Minimal 2 opsi wajib diisi untuk soal checkbox nomor {$questionIndex}.",
                    ])->withInput();
                }
                if (empty($question['checkbox_correct']) || count($question['checkbox_correct']) < 1) {
                    return back()->withErrors([
                        'questions' => "Minimal 1 jawaban benar wajib dipilih untuk soal checkbox nomor {$questionIndex}.",
                    ])->withInput();
                }
            }
        }

        try {
            DB::beginTransaction();

            // Update quiz data
            $quiz->update([
                'judul_quiz' => $validatedData['judul_quiz'],
                'deskripsi' => $validatedData['deskripsi'] ?? '',
                'waktu_menit' => $validatedData['waktu_menit'],
                'kategori_id' => $validatedData['categories'],
                'mata_pelajaran_id' => $validatedData['mapel'],
                'pengulangan_pekerjaan' => $validatedData['pengulangan'],
                'status' => $validatedData['status'],
            ]);

            // Get existing question IDs to track which ones to delete
            $existingQuestionIds = $quiz->soals->pluck('id')->toArray();
            $submittedQuestionIds = [];

            // Process each question
            foreach ($validatedData['questions'] as $questionData) {
                $soalData = [
                    'quiz_id' => $quiz->id,
                    'tipe' => $questionData['type'],
                    'pertanyaan' => $questionData['pertanyaan'],
                    'bobot' => $questionData['weight'],
                    'pilihan_a' => null,
                    'pilihan_b' => null,
                    'pilihan_c' => null,
                    'pilihan_d' => null,
                    'pilihan_e' => null,
                    'pilihan_f' => null,
                    'pilihan_g' => null,
                    'pilihan_h' => null,
                    'pilihan_i' => null,
                    'pilihan_j' => null,
                    'jawaban_benar' => null,
                ];

                // Handle different question types
                switch ($questionData['type']) {
                    case 'pilihan_ganda':
                        $soalData['pilihan_a'] = $questionData['pilihan_a'] ?? null;
                        $soalData['pilihan_b'] = $questionData['pilihan_b'] ?? null;
                        $soalData['pilihan_c'] = $questionData['pilihan_c'] ?? null;
                        $soalData['pilihan_d'] = $questionData['pilihan_d'] ?? null;
                        $soalData['pilihan_e'] = $questionData['pilihan_e'] ?? null;
                        $soalData['pilihan_f'] = $questionData['pilihan_f'] ?? null;
                        $soalData['pilihan_g'] = $questionData['pilihan_g'] ?? null;
                        $soalData['pilihan_h'] = $questionData['pilihan_h'] ?? null;
                        $soalData['pilihan_i'] = $questionData['pilihan_i'] ?? null;
                        $soalData['pilihan_j'] = $questionData['pilihan_j'] ?? null;
                        $soalData['jawaban_benar'] = $questionData['jawaban_benar'];
                        break;

                    case 'essay':
                        $soalData['jawaban_benar'] = $questionData['jawaban_benar'] ?? null;
                        break;

                    case 'benar_salah':
                        $soalData['jawaban_benar'] = $questionData['jawaban_benar'];
                        break;

                    case 'checkbox':
                        $checkboxOptions = $questionData['checkbox_options'];
                        $optionLetters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];

                        foreach ($optionLetters as $index => $letter) {
                            if (isset($checkboxOptions[$index])) {
                                $soalData['pilihan_'.$letter] = $checkboxOptions[$index];
                            }
                        }

                        // Store correct answers as comma-separated string
                        $correctAnswers = $questionData['checkbox_correct'];
                        $soalData['jawaban_benar'] = implode(',', $correctAnswers);
                        break;
                }

                // Update existing question or create new one
                if (! empty($questionData['id'])) {
                    $soal = Soal::findOrFail($questionData['id']);
                    $soal->update($soalData);
                    $submittedQuestionIds[] = $questionData['id'];
                } else {
                    $newSoal = Soal::create($soalData);
                    $submittedQuestionIds[] = $newSoal->id;
                }
            }

            // Delete questions that were removed
            $questionsToDelete = array_diff($existingQuestionIds, $submittedQuestionIds);
            if (! empty($questionsToDelete)) {
                Soal::whereIn('id', $questionsToDelete)->delete();
            }

            DB::commit();

            $statusMessage = $validatedData['status'] === 'Umum' ? 'diperbarui sebagai umum' : 'diperbarui sebagai privat';

            return redirect()->route('quiz.index')
                ->with('success', "Quiz berhasil {$statusMessage}!");

        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('Error updating quiz: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui quiz. Silakan coba lagi.'])
                ->withInput();
        }
    }

    private function generateQuizCode()
    {
        do {
            $code = 'QZ'.strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        } while (Quiz::where('kode_quiz', $code)->exists());

        return $code;
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus quiz ini.');
        }
        try {
            DB::beginTransaction();

            $quiz->soals()->delete();
            $quiz->delete();
            DB::commit();

            return redirect()->route('quiz.index')
                ->with('success', 'Quiz berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting quiz: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus quiz.']);
        }
    }

    public function start($id)
    {
        $quiz = Quiz::with('soals')->findOrFail($id);
        $startTime = now()->timestamp;

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

        return view('frontend.quiz_start', compact('quiz', 'startTime'));
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('soals')->findOrFail($id);
        $soals = $quiz->soals;

        // Initialize scoring variables
        $totalBobot = 0;
        $bobotBenar = 0;
        $jawabanBenar = 0;
        $jumlahSalah = 0;
        $detailJawaban = [];

        // Process each question based on its type
        foreach ($soals as $soal) {
            $totalBobot += $soal->bobot;
            $jawabanUser = null;
            $statusJawaban = 'salah';
            $bobotDiperoleh = 0;

            switch ($soal->tipe) {
                case 'pilihan_ganda':
                    $jawabanUser = $request->input('jawaban_'.$soal->id);
                    if ($jawabanUser === $soal->jawaban_benar) {
                        $bobotDiperoleh = $soal->bobot;
                        $bobotBenar += $soal->bobot;
                        $jawabanBenar++;
                        $statusJawaban = 'benar';
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;

                case 'benar_salah':
                    $jawabanUser = $request->input('jawaban_'.$soal->id);
                    if ($jawabanUser === $soal->jawaban_benar) {
                        $bobotDiperoleh = $soal->bobot;
                        $bobotBenar += $soal->bobot;
                        $jawabanBenar++;
                        $statusJawaban = 'benar';
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;

                case 'checkbox':
                    $jawabanUserArray = $request->input('jawaban_'.$soal->id, []);
                    $jawabanUser = is_array($jawabanUserArray) ? implode(',', $jawabanUserArray) : '';

                    // Casting string semua agar cocok saat dibanding
                    $correctAnswers = array_map('strval', explode(',', $soal->jawaban_benar));
                    $userAnswers = array_map('strval', $jawabanUserArray);

                    // Jawaban benar & salah
                    $jawabanBenarDipilih = array_intersect($correctAnswers, $userAnswers);
                    $jawabanSalahDipilih = array_diff($userAnswers, $correctAnswers);

                    $jumlahBenarDipilih = count($jawabanBenarDipilih);
                    $jumlahSalahDipilih = count($jawabanSalahDipilih);
                    $totalJawabanBenar = count($correctAnswers);

                    if ($totalJawabanBenar > 0) {
                        $bobotPerJawaban = $soal->bobot / $totalJawabanBenar;

                        // Hitung nilai akhir (penalti = 50% dari nilai benar)
                        $nilaiBenar = $jumlahBenarDipilih * $bobotPerJawaban;
                        $penalti = $jumlahSalahDipilih * ($bobotPerJawaban / 2);
                        $bobotDiperoleh = max(0, $nilaiBenar - $penalti);

                        $bobotBenar += $bobotDiperoleh;

                        // Status
                        if ($jumlahBenarDipilih === $totalJawabanBenar && $jumlahSalahDipilih === 0) {
                            $jawabanBenar++;
                            $statusJawaban = 'benar';
                        } elseif ($bobotDiperoleh > 0) {
                            $statusJawaban = 'sebagian';
                        } else {
                            $jumlahSalah++;
                            $statusJawaban = 'salah';
                        }
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;

                case 'essay':
                    $jawabanUser = $request->input('jawaban_'.$soal->id);
                    $statusJawaban = 'pending';
                    $bobotDiperoleh = 0;
                    // Essay tidak dihitung dalam jawaban benar/salah sampai dinilai manual
                    break;

                default:
                    $jumlahSalah++;
                    $statusJawaban = 'salah';
                    $bobotDiperoleh = 0;
                    break;
            }

            // Store detail for later insertion
            $detailJawaban[] = [
                'soal_id' => $soal->id,
                'jawaban_peserta' => $jawabanUser ?? '',
                'status_jawaban' => $statusJawaban,
                'bobot_soal' => (int) $soal->bobot,
                'bobot_diperoleh' => round($bobotDiperoleh, 2),
            ];
        }

        // Calculate final score based on weights
        $skor = $totalBobot > 0 ? round(($bobotBenar / $totalBobot) * 100, 2) : 0;

        // Calculate time taken
        $startTimestamp = (int) $request->input('start_time');
        $nowTimestamp = now()->timestamp;
        $waktuPengerjaan = max(0, $nowTimestamp - $startTimestamp);
        $waktuPengerjaanMenitDecimal = round($waktuPengerjaan / 60, 2);

        // Check if exam result already exists
        $hasil = HasilUjian::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($hasil) {
            // Update existing result
            $hasil->update([
                'skor' => $skor,
                'jumlah_benar' => $jawabanBenar,
                'jumlah_salah' => $jumlahSalah,
                'total_bobot' => $totalBobot,
                'bobot_diperoleh' => round($bobotBenar, 2),
                'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                'tanggal_ujian' => Carbon::now()->toDateString(),
            ]);

            // PERBAIKAN: Hapus detail lama dan masukkan yang baru untuk SEMUA quiz
            // (tidak hanya quiz umum)
            $hasil->detail()->delete();

            foreach ($detailJawaban as $detail) {
                HasilUjianDetail::create([
                    'hasil_ujian_id' => $hasil->id,
                    'soal_id' => $detail['soal_id'],
                    'jawaban_peserta' => $detail['jawaban_peserta'],
                    'status_jawaban' => $detail['status_jawaban'],
                    'bobot_soal' => $detail['bobot_soal'],
                    'bobot_diperoleh' => $detail['bobot_diperoleh'],
                ]);
            }
        } else {
            // Create new result
            $hasil = HasilUjian::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'skor' => $skor,
                'jumlah_benar' => $jawabanBenar,
                'jumlah_salah' => $jumlahSalah,
                'total_bobot' => $totalBobot,
                'bobot_diperoleh' => round($bobotBenar, 2),
                'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                'tanggal_ujian' => Carbon::now()->toDateString(),
            ]);

            // PERBAIKAN: Masukkan detail jawaban untuk SEMUA quiz
            // (tidak hanya quiz umum)
            foreach ($detailJawaban as $detail) {
                HasilUjianDetail::create([
                    'hasil_ujian_id' => $hasil->id,
                    'soal_id' => $detail['soal_id'],
                    'jawaban_peserta' => $detail['jawaban_peserta'],
                    'status_jawaban' => $detail['status_jawaban'],
                    'bobot_soal' => $detail['bobot_soal'],
                    'bobot_diperoleh' => $detail['bobot_diperoleh'],
                ]);
            }
        }

        return redirect()->route('quiz.hasil', $hasil->id)
            ->with('success', 'Quiz berhasil disubmit. Skor Anda: '.$skor.' (Bobot: '.round($bobotBenar, 2).'/'.$totalBobot.')');
    }

    public function hasil($id)
    {
        // Get exam result with quiz and related data
        $hasil = HasilUjian::with(['quiz', 'detail.soal', 'user'])->findOrFail($id);

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

        // Default empty detail results
        $hasil_detail = collect();

        // Show details only if quiz is public
        if ($hasil->quiz->status === 'Umum') {
            $hasil_detail = $hasil->detail()->with('soal')->get();
        }

        return view('frontend.quiz_hasil_pengerjaan', compact(
            'hasil',
            'ranking',
            'total_peserta',
            'top_performers',
            'hasil_detail',
        ));
    }
}
