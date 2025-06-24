<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Soal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BackendController extends Controller
{

public function index(Request $request)
{
    // Get base query for current user's quizzes
    $query = Quiz::with(['user', 'soals'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc');
    
    // Check if we should show all quizzes or just recent ones
    $showAll = $request->get('show_all', false);
    
    if (!$showAll) {
        // Default: show only quizzes from last 7 days for the main view
        // But we'll get all quizzes for stats and pass them to the view
        $allQuizzes = $query->get();
        $quizzes = $allQuizzes; // Pass all quizzes, let the view filter recent ones
    } else {
        // Show all quizzes (for full listing page)
        $quizzes = $query->paginate(12);
    }
    
    return view('backend.index', compact('quizzes', 'showAll'));
}

// Alternative method if you want to filter in controller:
public function indexAlternative(Request $request)
{
    $showAll = $request->get('show_all', false);
    
    // Get all user's quizzes for stats
    $allQuizzes = Quiz::with(['user', 'soals'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
    
    if ($showAll) {
        // Show all quizzes with pagination
        $quizzes = Quiz::with(['user', 'soals'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('backend.all', compact('quizzes', 'allQuizzes'));
    } else {
        // Show recent quizzes only
        $quizzes = $allQuizzes->where('created_at', '>=', now()->subDays(7));
        
        return view('backend.index', compact('quizzes', 'allQuizzes'));
    }
}
}
