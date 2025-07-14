<?php

namespace App\Providers;

use App\Models\HasilUjianDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $essaySoalBelumDinilai = [];

            if ($user) {
                $essaySoalBelumDinilai = HasilUjianDetail::where('bobot_diperoleh', 0)
                    ->whereHas('soal', function ($query) {
                        $query->where('tipe', 'essay');
                    })
                    ->whereHas('hasilUjian.quiz', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->with(['soal', 'hasilUjian.quiz'])
                    ->get();
            }

            $view->with('essaySoalBelumDinilai', $essaySoalBelumDinilai);
        });
    }
}
