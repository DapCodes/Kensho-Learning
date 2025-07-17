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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    public function index(Request $request)
{
    
    // Basic query for user's quizzes
    $query = Quiz::with(['kategori', 'mataPelajaran', 'soals', 'hasilUjian.user'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc');
    
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
        $userId = auth()->id();

        // Total quizzes created by admin
        $totalQuizzes = Quiz::where('user_id', $userId)->count();

        $activeQuizzes = Quiz::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $totalPeserta = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->distinct('user_id')->count();

        $totalSoal = Soal::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $totalDurasi = Quiz::where('user_id', $userId)->sum('waktu_menit');

        $totalSubmissions = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $averageScore = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->avg('skor');

        $completionRate = $totalPeserta > 0 ? ($totalSubmissions / $totalPeserta) * 100 : 0;

        $bestQuiz = Quiz::where('user_id', $userId)
            ->withAvg('hasilUjian', 'skor')
            ->orderBy('hasil_ujian_avg_skor', 'desc')
            ->first();

        $popularQuiz = Quiz::where('user_id', $userId)
            ->withCount('hasilUjian')
            ->orderByDesc('hasil_ujian_count')
            ->limit(3)
            ->get();

        $thisMonth = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->count();

        $lastMonth = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->whereBetween('created_at', [
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
        $userId = auth()->id();

        return Quiz::where('user_id', $userId)
            ->with(['hasilUjian' => function ($query) {
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
        $userId = auth()->id();

        return HasilUjianDetail::whereHas('hasilUjian.quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereHas('soal', function ($query) {
                $query->where('tipe', 'essay');
            })
            ->where('status_jawaban', 'pending')
            ->count();
    }


    private function getWeeklyStats()
    {
        $userId = auth()->id();
        $startOfWeek = Carbon::now()->startOfWeek();

        $weeklyData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $submissions = HasilUjian::whereHas('quiz', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
                ->whereDate('created_at', $date)
                ->count();

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
        $userId = auth()->id();

        return HasilUjian::select('user_id', DB::raw('AVG(skor) as avg_score'), DB::raw('COUNT(*) as total_attempts'))
            ->whereHas('quiz', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('user')
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
        $userId = auth()->id();
        $last30Days = Carbon::now()->subDays(30);

        return HasilUjian::whereHas('quiz', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('created_at', '>=', $last30Days)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as completions')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
