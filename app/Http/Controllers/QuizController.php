<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use App\Models\Kategori;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\MataPelajaran;
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
            'questions.*.option_a' => 'required|string|max:255',
            'questions.*.option_b' => 'required|string|max:255',
            'questions.*.option_c' => 'required|string|max:255',
            'questions.*.option_d' => 'required|string|max:255',
            'questions.*.correct_answer' => 'required|in:A,B,C,D',
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
            'questions.*.option_a.required' => 'Pilihan A wajib diisi.',
            'questions.*.option_b.required' => 'Pilihan B wajib diisi.',
            'questions.*.option_c.required' => 'Pilihan C wajib diisi.',
            'questions.*.option_d.required' => 'Pilihan D wajib diisi.',
            'questions.*.option_a.max' => 'Pilihan A maksimal 255 karakter.',
            'questions.*.option_b.max' => 'Pilihan B maksimal 255 karakter.',
            'questions.*.option_c.max' => 'Pilihan C maksimal 255 karakter.',
            'questions.*.option_d.max' => 'Pilihan D maksimal 255 karakter.',
            'questions.*.correct_answer.required' => 'Jawaban benar wajib dipilih.',
            'questions.*.correct_answer.in' => 'Jawaban benar harus A, B, C, atau D.',
        ]);

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
                Soal::create([
                    'quiz_id' => $quiz->id,
                    'pertanyaan' => $questionData['text'],
                    'pilihan_a' => $questionData['option_a'],
                    'pilihan_b' => $questionData['option_b'],
                    'pilihan_c' => $questionData['option_c'],
                    'pilihan_d' => $questionData['option_d'],
                    'jawaban_benar' => $questionData['correct_answer'],
                ]);
            }

            DB::commit();

            $statusMessage = $validatedData['visibility'] === 'Umum' ? 'umum' : 'dibuat sebagai umum';

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

    // controller untuk user
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
        $jawabanBenar = 0;

        foreach ($soals as $soal) {
            $jawabanUser = $request->input('jawaban_'.$soal->id);
            if ($jawabanUser === $soal->jawaban_benar) {
                $jawabanBenar++;
            }
        }

        $totalSoal = $soals->count();
        $jumlahSalah = $totalSoal - $jawabanBenar;
        $skor = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100) : 0;

        $startTimestamp = (int) $request->input('start_time');
        $nowTimestamp = now()->timestamp;

        $waktuPengerjaan = max(0, $nowTimestamp - $startTimestamp);
        $waktuPengerjaanMenitDecimal = round($waktuPengerjaan / 60, 2);

        // Cek apakah hasil ujian sudah ada sebelumnya
        $hasil = HasilUjian::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($hasil) {
            // Update data lama
            $hasil->update([
                'skor' => $skor,
                'jumlah_benar' => $jawabanBenar,
                'jumlah_salah' => $jumlahSalah,
                'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                'tanggal_ujian' => Carbon::now()->toDateString(),
            ]);

            // Jika status quiz Umum, hapus jawaban lama sebelum insert baru
            if ($quiz->status === 'Umum') {
                $hasil->detail()->delete();

                foreach ($soals as $soal) {
                    $jawabanUser = $request->input('jawaban_'.$soal->id);

                    HasilUjianDetail::create([
                        'hasil_ujian_id' => $hasil->id,
                        'soal_id' => $soal->id,
                        'jawaban_peserta' => $jawabanUser,
                        'status_jawaban' => $jawabanUser === $soal->jawaban_benar ? 'benar' : 'salah',
                    ]);
                }
            }
        } else {
            // Buat data baru
            $hasil = HasilUjian::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'skor' => $skor,
                'jumlah_benar' => $jawabanBenar,
                'jumlah_salah' => $jumlahSalah,
                'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                'tanggal_ujian' => Carbon::now()->toDateString(),
            ]);

            // Jika status quiz Umum, insert jawaban detail
            if ($quiz->status === 'Umum') {
                foreach ($soals as $soal) {
                    $jawabanUser = $request->input('jawaban_'.$soal->id);

                    HasilUjianDetail::create([
                        'hasil_ujian_id' => $hasil->id,
                        'soal_id' => $soal->id,
                        'jawaban_peserta' => $jawabanUser,
                        'status_jawaban' => $jawabanUser === $soal->jawaban_benar ? 'benar' : 'salah',
                    ]);
                }
            }
        }

        return redirect()->route('quiz.hasil', $hasil->id)
            ->with('success', 'Quiz berhasil disubmit. Skor Anda: '.$skor);
    }

    public function hasil($id)
    {
        // Ambil hasil ujian beserta quiz dan relasi lainnya
        $hasil = HasilUjian::with(['quiz', 'detail.soal', 'user'])->findOrFail($id);

        // Hitung ranking berdasarkan skor lebih tinggi
        $ranking = HasilUjian::where('quiz_id', $hasil->quiz_id)
            ->where('skor', '>', $hasil->skor)
            ->count() + 1;

        // Hitung total peserta pada quiz yang sama
        $total_peserta = HasilUjian::where('quiz_id', $hasil->quiz_id)->count();

        // Ambil 10 peserta teratas berdasarkan skor dan waktu
        $top_performers = HasilUjian::with('user')
            ->where('quiz_id', $hasil->quiz_id)
            ->orderBy('skor', 'desc')
            ->orderBy('waktu_pengerjaan', 'asc')
            ->take(10)
            ->get();

        // Default hasil_detail kosong
        $hasil_detail = collect();

        // Tampilkan detail hanya jika quiz bersifat umum
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
