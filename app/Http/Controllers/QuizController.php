<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use App\Models\Kategori;
use App\Models\MataPelajaran;
use App\Models\Quiz;
use App\Models\Soal;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['user', 'soals'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.quiz.index', compact('quizzes'));
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
            // Multiple choice fields
            'questions.*.option_a' => 'nullable|string|max:255',
            'questions.*.option_b' => 'nullable|string|max:255',
            'questions.*.option_c' => 'nullable|string|max:255',
            'questions.*.option_d' => 'nullable|string|max:255',
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
                    'jawaban_benar' => null,
                ];

                // Handle different question types
                switch ($questionData['type']) {
                    case 'pilihan_ganda':
                        $soalData['pilihan_a'] = $questionData['option_a'];
                        $soalData['pilihan_b'] = $questionData['option_b'];
                        $soalData['pilihan_c'] = $questionData['option_c'];
                        $soalData['pilihan_d'] = $questionData['option_d'];
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
                        // Store checkbox options in pilihan_a, pilihan_b, etc.
                        $checkboxOptions = $questionData['checkbox_options'];
                        if (isset($checkboxOptions[0])) {
                            $soalData['pilihan_a'] = $checkboxOptions[0];
                        }
                        if (isset($checkboxOptions[1])) {
                            $soalData['pilihan_b'] = $checkboxOptions[1];
                        }
                        if (isset($checkboxOptions[2])) {
                            $soalData['pilihan_c'] = $checkboxOptions[2];
                        }
                        if (isset($checkboxOptions[3])) {
                            $soalData['pilihan_d'] = $checkboxOptions[3];
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
        try {
            $quiz = Quiz::with(['soals', 'kategori'])->findOrFail($id);

            $categories = Kategori::all();
            $mataPelajaran = MataPelajaran::all();

            return view('backend.quiz.edit', compact('quiz', 'categories', 'mataPelajaran'));

        } catch (\Exception $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Quiz tidak ditemukan atau terjadi kesalahan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $quiz = Quiz::with('soals')->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'judul_quiz' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:1000',
                'waktu_menit' => 'required|integer|min:1|max:300',
                'status' => 'required|in:Privat,Umum',
                'questions' => 'required|array|min:1|max:50',
                'questions.*.pertanyaan' => 'required|string|max:1000',
                'questions.*.pilihan_a' => 'required|string|max:255',
                'questions.*.pilihan_b' => 'required|string|max:255',
                'questions.*.pilihan_c' => 'required|string|max:255',
                'questions.*.pilihan_d' => 'required|string|max:255',
                'questions.*.jawaban_benar' => 'required|in:A,B,C,D',
                'questions.*.id' => 'nullable|integer|exists:soals,id',
            ], [
                'judul_quiz.required' => 'Judul quiz wajib diisi.',
                'judul_quiz.max' => 'Judul quiz tidak boleh lebih dari 255 karakter.',
                'waktu_menit.required' => 'Durasi quiz wajib diisi.',
                'waktu_menit.min' => 'Durasi quiz minimal 1 menit.',
                'waktu_menit.max' => 'Durasi quiz maksimal 300 menit.',
                'status.required' => 'Status quiz wajib dipilih.',
                'status.in' => 'Status quiz harus Privat atau Umum.',
                'questions.required' => 'Quiz harus memiliki minimal satu soal.',
                'questions.min' => 'Quiz harus memiliki minimal satu soal.',
                'questions.max' => 'Quiz maksimal memiliki 50 soal.',
                'questions.*.pertanyaan.required' => 'Teks soal wajib diisi.',
                'questions.*.pertanyaan.max' => 'Teks soal tidak boleh lebih dari 1000 karakter.',
                'questions.*.pilihan_a.required' => 'Pilihan A wajib diisi.',
                'questions.*.pilihan_b.required' => 'Pilihan B wajib diisi.',
                'questions.*.pilihan_c.required' => 'Pilihan C wajib diisi.',
                'questions.*.pilihan_d.required' => 'Pilihan D wajib diisi.',
                'questions.*.jawaban_benar.required' => 'Jawaban benar wajib dipilih.',
                'questions.*.jawaban_benar.in' => 'Jawaban benar harus A, B, C, atau D.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
            }

            DB::beginTransaction();

            try {
                $quiz->update([
                    'judul_quiz' => $request->judul_quiz,
                    'deskripsi' => $request->deskripsi,
                    'waktu_menit' => $request->waktu_menit,
                    'status' => $request->status,
                    'user_id' => $quiz->user_id,
                    'kategori_id' => $request->categories,
                    'mata_pelajaran_id' => $request->mapel,
                    'kode_quiz' => $quiz->kode_quiz,
                    'tanggal_buat' => $quiz->tanggal_buat,
                ]);

                $existingQuestionIds = $quiz->soals->pluck('id')->toArray();
                $updatedQuestionIds = [];

                foreach ($request->questions as $index => $questionData) {
                    if (isset($questionData['id']) && ! empty($questionData['id'])) {
                        $question = Soal::findOrFail($questionData['id']);

                        if ($question->quiz_id !== $quiz->id) {
                            throw new \Exception('Invalid question ID provided.');
                        }

                        $question->update([
                            'pertanyaan' => $questionData['pertanyaan'],
                            'pilihan_a' => $questionData['pilihan_a'],
                            'pilihan_b' => $questionData['pilihan_b'],
                            'pilihan_c' => $questionData['pilihan_c'],
                            'pilihan_d' => $questionData['pilihan_d'],
                            'jawaban_benar' => $questionData['jawaban_benar'],
                        ]);

                        $updatedQuestionIds[] = $question->id;

                    } else {
                        $newQuestion = Soal::create([
                            'quiz_id' => $quiz->id,
                            'pertanyaan' => $questionData['pertanyaan'],
                            'pilihan_a' => $questionData['pilihan_a'],
                            'pilihan_b' => $questionData['pilihan_b'],
                            'pilihan_c' => $questionData['pilihan_c'],
                            'pilihan_d' => $questionData['pilihan_d'],
                            'jawaban_benar' => $questionData['jawaban_benar'],
                        ]);

                        $updatedQuestionIds[] = $newQuestion->id;
                    }
                }

                $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
                if (! empty($questionsToDelete)) {
                    Soal::whereIn('id', $questionsToDelete)->delete();
                }

                DB::commit();

                return redirect()->route('quiz.index')
                    ->with('success', 'Quiz berhasil diperbarui!');

            } catch (\Exception $e) {
                DB::rollback();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat memperbarui quiz: '.$e->getMessage());
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Quiz tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Terjadi kesalahan yang tidak terduga.');
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


// Updated Quiz Controller Methods

public function start($id)
{
    $quiz = Quiz::with('soals')->findOrFail($id);
    $startTime = now()->timestamp; // waktu mulai ujian

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
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
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
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
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
                        $jawabanUserArray = $request->input('jawaban_' . $soal->id, []);
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
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
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

            // If quiz is public, delete old details and insert new ones
            if ($quiz->status === 'Umum') {
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

            // If quiz is public, insert answer details
            if ($quiz->status === 'Umum') {
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
        }

        return redirect()->route('quiz.hasil', $hasil->id)
            ->with('success', 'Quiz berhasil disubmit. Skor Anda: ' . $skor . ' (Bobot: ' . round($bobotBenar, 2) . '/' . $totalBobot . ')');
    }

    public function hasil($id)
    {
        // Get exam result with quiz and related data
        $hasil = HasilUjian::with(['quiz', 'detail.soal', 'user'])->findOrFail($id);

        // Calculate ranking based on weighted score
        $ranking = HasilUjian::where('quiz_id', $hasil->quiz_id)
            ->where(function($query) use ($hasil) {
                $query->where('bobot_diperoleh', '>', $hasil->bobot_diperoleh)
                    ->orWhere(function($subQuery) use ($hasil) {
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
            'hasil_detail'
        ));
    }


}

