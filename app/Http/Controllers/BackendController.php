<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use App\Models\Kategori;
use App\Models\MataPelajaran;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Basic query for quizzes based on admin level
        $query = Quiz::with(['kategori', 'mataPelajaran', 'soals', 'hasilUjian.user']);

        // Apply filter based on admin level
        if ($user->isAdmin === '1') {
            // Admin level 1: Show only quizzes created by this user
            $query->where('user_id', $user->id);
        } elseif ($user->isAdmin === '2') {
            // Admin level 2: Show all quizzes (no filter needed)
            // $query remains unchanged to show all quizzes
        } else {
            // For non-admin users, show only their own quizzes (fallback)
            $query->where('user_id', $user->id);
        }

        $query->orderBy('created_at', 'desc');

        $showAll = $request->get('show_all', false);

        // Get all categories and mata pelajaran for filtering
        $categories = Kategori::all();
        $mataPelajaran = MataPelajaran::all();

        // Get recent quizzes (last 7 days)
        $recentQuizzes = $query->clone()
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->with(['soals', 'hasilUjian'])
            ->get();

        // Get all quizzes for the user
        if (! $showAll) {
            $quizzes = $query->paginate(12);
        } else {
            $quizzes = $query->get();
        }

        // Calculate comprehensive statistics
        $stats = $this->getAdminStats();

        // Get quiz performance data
        $quizPerformance = $this->getQuizPerformanceData();

        // Get pending essays count
        $pendingEssaysCount = $this->getPendingEssaysCount();

        // Get weekly statistics
        $weeklyStats = $this->getWeeklyStats();

        // Get top performing students
        $topStudents = $this->getTopStudents();

        // Get quiz completion trends
        $completionTrends = $this->getCompletionTrends();

        // Get recent messages
        $recentMessages = $this->getRecentMessages();

        return view('backend.index', compact(
            'quizzes',
            'recentQuizzes',
            'showAll',
            'categories',
            'mataPelajaran',
            'stats',
            'quizPerformance',
            'pendingEssaysCount',
            'weeklyStats',
            'topStudents',
            'completionTrends',
            'recentMessages'
        ));
    }

    /**
     * Get recent messages for dashboard
     */
    private function getRecentMessages($limit = 5)
    {
        return \App\Models\Pesan::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getAdminStats()
    {
        $user = auth()->user();

        // Base queries for quizzes based on admin level
        if ($user->isAdmin === '1') {
            // Admin level 1: Only their own quizzes
            $quizQuery = Quiz::where('user_id', $user->id);
            $hasilUjianQuery = HasilUjian::whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
            $soalQuery = Soal::whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        } elseif ($user->isAdmin === '2') {
            // Admin level 2: All quizzes
            $quizQuery = Quiz::query();
            $hasilUjianQuery = HasilUjian::query();
            $soalQuery = Soal::query();
        } else {
            // Fallback: Only their own quizzes
            $quizQuery = Quiz::where('user_id', $user->id);
            $hasilUjianQuery = HasilUjian::whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
            $soalQuery = Soal::whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        // Calculate statistics
        $totalQuizzes = $quizQuery->count();
        $activeQuizzes = $quizQuery->clone()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $totalPeserta = $hasilUjianQuery->clone()
            ->distinct('user_id')
            ->count();

        $totalSoal = $soalQuery->count();
        $totalDurasi = $quizQuery->clone()->sum('waktu_menit');
        $totalSubmissions = $hasilUjianQuery->clone()->count();
        $averageScore = $hasilUjianQuery->clone()->avg('skor');

        $completionRate = $totalPeserta > 0 ? ($totalSubmissions / $totalPeserta) * 100 : 0;

        $bestQuiz = $quizQuery->clone()
            ->withAvg('hasilUjian', 'skor')
            ->orderBy('hasil_ujian_avg_skor', 'desc')
            ->first();

        $popularQuiz = $quizQuery->clone()
            ->withCount('hasilUjian')
            ->orderByDesc('hasil_ujian_count')
            ->limit(3)
            ->get();

        $thisMonth = $hasilUjianQuery->clone()
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])->count();

        $lastMonth = $hasilUjianQuery->clone()
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth(),
            ])->count();

        $growthRate = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;

        return [
            'totalQuizzes' => $totalQuizzes,
            'activeQuizzes' => $activeQuizzes,
            'totalPeserta' => $totalPeserta,
            'totalSoal' => $totalSoal,
            'totalDurasi' => $totalDurasi,
            'totalSubmissions' => $totalSubmissions,
            'averageScore' => round($averageScore, 1),
            'completionRate' => round($completionRate, 1),
            'bestQuiz' => $bestQuiz,
            'popularQuiz' => $popularQuiz,
            'growthRate' => round($growthRate, 1),
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
        ];
    }

    private function getQuizPerformanceData()
    {
        $user = auth()->user();

        // Base query for quizzes based on admin level
        $query = Quiz::query();
        if ($user->isAdmin === '1') {
            $query->where('user_id', $user->id);
        }
        // For admin level 2, no filter needed (show all quizzes)

        return $query->with(['hasilUjian' => function ($query) {
            $query->select('quiz_id', 'skor', 'created_at', 'waktu_pengerjaan');
        }])
            ->get()
            ->map(function ($quiz) {
                $results = $quiz->hasilUjian;
                $totalPeserta = $results->count();
                $rataRataSkor = $results->avg('skor');
                $skorTertinggi = $results->max('skor');
                $skorTerendah = $results->min('skor');
                $tingkatKelulusan = $results->where('skor', '>=', 60)->count();
                $rataRataWaktu = $results->avg('waktu_pengerjaan');

                return [
                    'quiz_id' => $quiz->id,
                    'judul' => $quiz->judul_quiz,
                    'total_peserta' => $totalPeserta,
                    'rata_rata_skor' => round($rataRataSkor, 1),
                    'skor_tertinggi' => $skorTertinggi,
                    'skor_terendah' => $skorTerendah,
                    'tingkat_kelulusan' => $tingkatKelulusan,
                    'persentase_kelulusan' => $totalPeserta > 0 ? round(($tingkatKelulusan / $totalPeserta) * 100, 1) : 0,
                    'rata_rata_waktu' => round($rataRataWaktu, 1),
                    'created_at' => $quiz->created_at,
                    'difficulty_level' => $this->calculateDifficultyLevel($rataRataSkor),
                ];
            })
            ->sortByDesc('total_peserta')
            ->take(3);
    }

    private function calculateDifficultyLevel($averageScore)
    {
        if ($averageScore >= 80) {
            return 'Mudah';
        }
        if ($averageScore >= 60) {
            return 'Sedang';
        }
        if ($averageScore >= 40) {
            return 'Sulit';
        }

        return 'Sangat Sulit';
    }

    private function getPendingEssaysCount()
    {
        $user = auth()->user();

        $query = HasilUjianDetail::query();

        if ($user->isAdmin === '1') {
            $query->whereHas('hasilUjian.quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        // For admin level 2, no filter needed (show all)

        return $query->whereHas('soal', function ($query) {
            $query->where('tipe', 'essay');
        })
            ->where('status_jawaban', 'pending')
            ->count();
    }

    private function getWeeklyStats()
    {
        $user = auth()->user();
        $startOfWeek = Carbon::now()->startOfWeek();
        $weeklyData = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);

            $query = HasilUjian::whereDate('created_at', $date);

            if ($user->isAdmin === '1') {
                $query->whereHas('quiz', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            }
            // For admin level 2, no filter needed (show all)

            $submissions = $query->count();

            $weeklyData[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('l'),
                'submissions' => $submissions,
            ];
        }

        return $weeklyData;
    }

    private function getTopStudents()
    {
        $user = auth()->user();

        $query = HasilUjian::select('user_id', DB::raw('AVG(skor) as avg_score'), DB::raw('COUNT(*) as total_attempts'));

        if ($user->isAdmin === '1') {
            $query->whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        // For admin level 2, no filter needed (show all)

        return $query->with('user')
            ->groupBy('user_id')
            ->orderByDesc('avg_score')
            ->take(10)
            ->get()
            ->map(function ($result) {
                return [
                    'user' => $result->user,
                    'avg_score' => round($result->avg_score, 1),
                    'total_attempts' => $result->total_attempts,
                ];
            });
    }

    private function getCompletionTrends()
    {
        $user = auth()->user();
        $last30Days = Carbon::now()->subDays(30);

        $query = HasilUjian::where('created_at', '>=', $last30Days);

        if ($user->isAdmin === '1') {
            $query->whereHas('quiz', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        // For admin level 2, no filter needed (show all)

        return $query->selectRaw('DATE(created_at) as date, COUNT(*) as completions')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
