@extends('layouts.frontend')
@section('content')
<div class="container-fluid py-4">
    
    <!-- Header Section -->
    <div class="card bg-gradient-primary shadow-lg position-relative overflow-hidden mb-5 border-0">
        <div class="card-body px-4 py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <h2 class="fw-bold mb-3 text-white">Detail Quiz</h2>
                    <p class="text-white-75 mb-3 fs-5">Lihat informasi lengkap sebelum memulai quiz</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="{{ route('home') }}">
                                    <i class="fas fa-home me-1"></i>Beranda
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="{{ route('quiz.index') }}">
                                    Quiz
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="text-center">
                        <i class="fas fa-clipboard-list text-white opacity-75" style="font-size: 6rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="position-absolute top-0 end-0 opacity-15">
            <div class="bg-white rounded-circle" style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
        </div>
        <div class="position-absolute bottom-0 start-0 opacity-15">
            <div class="bg-white rounded-circle" style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
        </div>
    </div>

    <div class="row">
        <!-- Quiz Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h4 class="card-title mb-0 text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Quiz
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h3 class="text-dark mb-2">{{ $quiz->judul_quiz }}</h3>
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-primary-subtle text-primary fs-6 me-2">
                                <i class="fas fa-tag me-1"></i>{{ $quiz->kategori->nama_kategori }}
                            </span>
                            <span class="badge {{ $quiz->status == 'published' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ ucfirst($quiz->status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($quiz->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-align-left me-2"></i>Deskripsi Quiz:
                        </h6>
                        <div class="bg-light p-3 rounded">
                            <p class="text-dark mb-0 lh-lg">{{ $quiz->deskripsi }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Quiz Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-primary-subtle rounded">
                                <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-primary">Durasi</h6>
                                    <span class="text-dark fw-bold">{{ $quiz->waktu_menit }} menit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-success-subtle rounded">
                                <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-list-ol text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-success">Total Soal</h6>
                                    <span class="text-dark fw-bold">{{ $quiz->soals->count() }} pertanyaan</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-info-subtle rounded">
                                <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-calendar-alt text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-info">Dibuat</h6>
                                    <span class="text-dark fw-bold">{{ $quiz->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Instructions -->
                    <div class="alert alert-info border-0 shadow-sm">
                        <h6 class="alert-heading mb-3">
                            <i class="fas fa-lightbulb me-2"></i>Petunjuk Pengerjaan:
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li>Bacalah setiap pertanyaan dengan teliti</li>
                            <li>Pilih jawaban yang paling tepat dari pilihan yang tersedia</li>
                            <li>Waktu pengerjaan adalah {{ $quiz->waktu_menit }} menit</li>
                            <li>Pastikan koneksi internet stabil selama mengerjakan quiz</li>
                            <li>Quiz akan otomatis tersimpan ketika waktu habis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quiz Action Card -->
            <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 2rem;">
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-primary bg-gradient rounded-circle mx-auto mb-3 d-flex justify-content-center align-items-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-play text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="mb-2">Siap Mengerjakan Quiz?</h5>
                        <p class="text-muted mb-0">Klik tombol di bawah untuk memulai quiz</p>
                    </div>

                    @if($quiz->soals->count() > 0)
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('quiz.start', $quiz->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-play-circle me-2"></i>Mulai Quiz
                            </a>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Pastikan Anda siap sebelum memulai quiz
                        </small>
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Quiz belum memiliki soal
                        </div>
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-lock me-2"></i>Quiz Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>

            <!-- Quiz Summary -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Ringkasan Quiz
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-primary mb-1">{{ $quiz->soals->count() }}</h4>
                                <small class="text-muted">Pertanyaan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-1">{{ $quiz->waktu_menit }}</h4>
                                <small class="text-muted">Menit</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Kategori:</span>
                        <span class="fw-bold">{{ $quiz->kategori->nama_kategori }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Status:</span>
                        <span class="badge {{ $quiz->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($quiz->status) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Dibuat:</span>
                        <span class="fw-bold">{{ $quiz->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Quiz
                </a>
                
                @if($quiz->soals->count() > 0)
                <a href="{{ route('quiz.start', $quiz->id) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-play-circle me-2"></i>Mulai Quiz Sekarang
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0a58ca);
    border: none;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0a58ca, #084298);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.sticky-top {
    position: sticky;
    z-index: 1020;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.alert-warning {
    border-left-color: #ffc107;
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}

.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.lh-lg {
    line-height: 1.75 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .sticky-top {
        position: relative;
        top: auto !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-lg {
        width: 100%;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add loading state to quiz start button
    const startButtons = document.querySelectorAll('a[href*="quiz.start"]');
    startButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat Quiz...';
            this.classList.add('disabled');
            
            // Re-enable after 3 seconds if page doesn't navigate
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('disabled');
            }, 3000);
        });
    });
});
</script>
@endsection