@extends('layouts.backend')
@section('content')
@include('layouts.components-backend.css')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Quiz Terbaru!!</h3>
                    <p class="text-white-75 mb-3">Quiz terbaru dalam 7 Hari terakhir.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Dasbor
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <img src="{{asset('assets/backend/images/breadcrumb/ChatBc.png')}}" 
                             alt="quiz-dashboard" 
                             class="img-fluid" 
                             style="max-height: 120px; filter: brightness(1.1);" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="position-absolute top-0 end-0 opacity-25">
            <div class="bg-white rounded-circle" style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
        </div>
        <div class="position-absolute bottom-0 start-0 opacity-25">
            <div class="bg-white rounded-circle" style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
        </div>
    </div>
    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0">Quiz yang anda cari tidak di temukan??</h5>
                    <small class="text-muted">Masukan kode quiz pada kolom sebelah kanan!!</small>
                </div>
                <div class="col-md-4 text-end">
                    <form action="{{ route('quiz.checkKode') }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" name="kode_quiz" class="form-control me-2" placeholder="Masukkan kode quiz..." required>
                        <button type="submit" class="btn btn-primary">Cek</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Cards -->
    <div class="row">
        @php
            $recentQuizzes = $quizzes->where('created_at', '>=', now()->subDays(7));
        @endphp
        
        @forelse($recentQuizzes as $index => $quiz)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card quiz-card h-100 position-relative" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="card-body pb-0">
                        <!-- Quiz Title -->
                        <h5 class="card-title fw-bold mb-2" title="{{ $quiz->judul_quiz }}">
                            {{ Str::limit($quiz->judul_quiz, 45) }}
                        </h5>

                        <!-- Quiz Description -->
                        <p class="card-text text-muted small mb-3">
                            {{ $quiz->deskripsi ? Str::limit($quiz->deskripsi, 80) : 'Tidak ada deskripsi' }}
                        </p>

                        <!-- Quiz Code -->
                        @if($quiz->kode_quiz)
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between bg-light rounded p-2">
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-key text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $quiz->kode_quiz }}</span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary copy-btn" 
                                            data-quiz-code="{{ $quiz->kode_quiz }}" 
                                            title="Salin Kode Quiz">
                                        <i class="ti ti-copy"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Quiz Stats -->
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="stats-item">
                                    <i class="ti ti-file-text text-primary d-block mb-1"></i>
                                    <span class="fw-bold d-block">{{ $quiz->soals->count() }}</span>
                                    <small class="text-muted">Soal</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stats-item">
                                    <i class="ti ti-clock text-warning d-block mb-1"></i>
                                    <span class="fw-bold d-block">{{ $quiz->waktu_menit }}</span>
                                    <small class="text-muted">Menit</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stats-item">
                                    <i class="ti ti-calendar text-info d-block mb-1"></i>
                                    <span class="fw-bold d-block">{{ \Carbon\Carbon::parse($quiz->tanggal_buat)->format('d/m') }}</span>
                                    <small class="text-muted">Dibuat</small>
                                </div>
                            </div>
                        </div>

                        <!-- Created Date -->
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="ti ti-calendar me-1"></i>
                                Dibuat {{ \Carbon\Carbon::parse($quiz->tanggal_buat)->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <div class="row g-2">
                            <div class="col-12">
                                <a href="{{ route('quiz.detail', $quiz->id) }}" class="btn btn-primary w-100 btn-action">
                                    Kerjakan Sekarang!
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="ti ti-file-text display-1 text-muted"></i>
                        </div>
                        <h3 class="mb-3">Tidak Ada Quiz Terbaru</h3>
                        <p class="text-muted mb-4">
                            Belum ada quiz yang dibuat dalam 7 hari terakhir. Mulai dengan membuat quiz baru!
                        </p>
                        <a href="{{ route('quiz.create') }}" class="btn btn-primary btn-lg">
                            <i class="ti ti-plus me-2"></i>Buat Quiz Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Show All Quizzes Button -->
    @if($recentQuizzes->count() > 0 && $quizzes->count() > $recentQuizzes->count())
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary" id="showAllQuizzes">
                <i class="ti ti-eye me-2"></i>Lihat Semua Quiz ({{ $quizzes->count() - $recentQuizzes->count() }} lainnya)
            </button>
        </div>
    @endif
</div>

<!-- Toast Container -->
<div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

<style>
:root {
    --primary-color: #5d87ff;
    --success-color: #13deb9;
    --warning-color: #ffae1f;
    --info-color: #539bff;
    --danger-color: #fa896b;
}

.modern-card {
    border-radius: 15px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.quiz-card {
    border-radius: 20px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.quiz-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.2);
}

.delete-btn {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(220,53,69,0.3);
    transition: all 0.3s ease;
}

.delete-btn:hover {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

.new-badge {
    border-radius: 15px;
    font-size: 0.75rem;
    padding: 5px 10px;
    box-shadow: 0 2px 10px rgba(19,222,185,0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.copy-btn {
    border-radius: 8px;
    padding: 4px 8px;
    transition: all 0.2s ease;
}

.copy-btn:hover {
    transform: scale(1.1);
}

.stats-item {
    padding: 10px 5px;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.stats-item:hover {
    background: rgba(93,135,255,0.1);
}

.btn-action {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.toast {
    border-radius: 15px;
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    min-width: 300px;
}

/* Animation for cards */
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

.quiz-card {
    animation: fadeInUp 0.6s ease forwards;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .quiz-card {
        margin-bottom: 20px;
    }
    
    .modern-card {
        margin-bottom: 15px;
    }
    
    .btn-action {
        font-size: 0.875rem;
        padding: 8px 12px;
    }
}
</style>

<script>
// Simple and reliable copy function
function copyToClipboard(text) {
    // Create temporary textarea
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    textarea.style.top = '0';
    textarea.style.left = '0';
    
    document.body.appendChild(textarea);
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices
    
    let success = false;
    try {
        success = document.execCommand('copy');
    } catch (err) {
        console.error('Copy failed:', err);
    }
    
    document.body.removeChild(textarea);
    return success;
}

// Show toast notification
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    
    // Remove existing toasts
    toastContainer.innerHTML = '';
    
    const toast = document.createElement('div');
    toast.className = `toast show`;
    toast.setAttribute('role', 'alert');
    
    const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    const icon = type === 'success' ? 'ti-check' : type === 'error' ? 'ti-x' : 'ti-info-circle';
    
    toast.innerHTML = `
        <div class="toast-header ${bgColor} text-white border-0">
            <i class="ti ${icon} me-2"></i>
            <strong class="me-auto">${type === 'success' ? 'Berhasil' : type === 'error' ? 'Error' : 'Info'}</strong>
            <button type="button" class="btn-close btn-close-white ms-2" onclick="this.closest('.toast').remove()"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 4000);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Handle copy buttons
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const quizCode = this.getAttribute('data-quiz-code');
            
            if (copyToClipboard(quizCode)) {
                showToast(`Kode quiz <strong>${quizCode}</strong> berhasil disalin!`, 'success');
                
                // Visual feedback
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="ti ti-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-primary');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-primary');
                }, 1000);
            } else {
                showToast(`Gagal menyalin kode. Kode quiz: ${quizCode}`, 'error');
            }
        });
    });
    
    // Show all quizzes functionality
    const showAllBtn = document.getElementById('showAllQuizzes');
    if (showAllBtn) {
        showAllBtn.addEventListener('click', function() {
            // This could redirect to a full quiz list page or load more via AJAX
            window.location.href = '{{ route("quiz.index") }}?show_all=true';
        });
    }
});
</script>
@endsection