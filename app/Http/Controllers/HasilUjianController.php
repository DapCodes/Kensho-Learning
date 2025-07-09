<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use Illuminate\Support\Facades\Auth;

class HasilUjianController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;

        // Ambil semua histori berdasarkan user login, dengan relasi quiz dan user
        $histori = HasilUjian::with('quiz')
            ->where('user_id', $user)
            ->latest()
            ->get();

        return view('frontend.histori_pengerjaan', compact('histori'));
    }
}
