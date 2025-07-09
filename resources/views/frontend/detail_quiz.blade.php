@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <div class="quiz-container">
        <!-- Main Card -->
        <div class="quiz-card">
            <!-- Header -->
            <div class="quiz-header">
                <span class="quiz-category">{{ $quiz->kategori->nama_kategori }}</span>
                <h1 class="quiz-title text-white">{{ $quiz->judul_quiz }}</h1>
                @if($quiz->deskripsi)
                <p class="quiz-description">{{ $quiz->deskripsi }}</p>
                @endif
            </div>

            <!-- Quiz Info -->
            <div class="quiz-info">
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>{{ $quiz->waktu_menit }}</h3>
                        <p>Menit</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-list"></i>
                    <div>
                        <h3>{{ $quiz->soals->count() }}</h3>
                        <p>Soal</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-{{ $quiz->status == 'published' ? 'check' : 'pause' }}"></i>
                    <div>
                        <span class="status-badge status-{{ $quiz->status }}">
                            {{ ucfirst($quiz->status) }}
                        </span>
                        <p>Status</p>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>Petunjuk</h3>
                <ul>
                    <li>Baca setiap soal dengan teliti</li>
                    <li>Pilih jawaban yang paling tepat</li>
                    <li>Waktu pengerjaan {{ $quiz->waktu_menit }} menit</li>
                    <li>Pastikan koneksi internet stabil</li>
                    <li>Jangan membuka tab lain selama ujian</li>
                </ul>
            </div>

            <!-- Action -->
            <div class="quiz-action">
                @if($quiz->soals->count() > 0)
                    <label class="ready-check w-75">
                        <span class="fw-light">Jika sudah mengerjakan quiz ini sebelumnya, maka hasil pengerjaan quiz sebelumnya akan di hapus dan di perbarui. <span class="text-danger">*</span></span>
                    </label> 
                    <label class="ready-check">
                        <input type="checkbox" id="readyCheck">
                        <span>Saya sudah siap mengerjakan quiz</span>
                    </label> <br>
                    <form action="{{ route('quiz.start', $quiz->id) }}" method="post">
                        <button id="startBtn" type="submit" class="start-btn" disabled>
                            <i class="fas fa-play"></i>
                            Mulai Quiz
                        </button>
                    </form>
                @else
                    <div class="no-quiz">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Quiz belum memiliki soal</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="quiz-footer">
                <a href="{{ route('dasbor') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Container */
.quiz-container {
    max-width: 800px;
    margin: auto;
    margin-bottom: 50px;
    padding: 0 1rem;
}

/* Card */
.quiz-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Header */
.quiz-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.quiz-category {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.quiz-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    line-height: 1.2;
}

.quiz-description {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0;
}

/* Info Section */
.quiz-info {
    display: flex;
    justify-content: space-around;
    padding: 2rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.info-item {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.info-item i {
    font-size: 1.5rem;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.info-item h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: #2d3748;
}

.info-item p {
    font-size: 0.9rem;
    color: #718096;
    margin: 0;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-published {
    background: #48bb78;
    color: white;
}

.status-draft {
    background: #a0aec0;
    color: white;
}

/* Instructions */
.instructions {
    padding: 2rem;
}

.instructions h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3748;
}

.instructions ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.instructions li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    color: #4a5568;
}

.instructions li:last-child {
    border-bottom: none;
}

.instructions li::before {
    content: "✓";
    color: #48bb78;
    margin-right: 0.5rem;
    font-weight: bold;
}

/* Action Section */
.quiz-action {
    padding: 2rem;
    text-align: center;
    background: #f8f9fa;
}

.ready-check {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    cursor: pointer;
    font-weight: 500;
    color: #4a5568;
}

.ready-check input {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
}

.start-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.start-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.start-btn:disabled {
    background: #a0aec0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.no-quiz {
    text-align: center;
    padding: 2rem;
    color: #e53e3e;
}

.no-quiz i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.no-quiz p {
    font-size: 1.1rem;
    margin: 0;
}

/* Footer */
.quiz-footer {
    padding: 1.5rem 2rem;
    text-align: center;
    border-top: 1px solid #e2e8f0;
}

.back-link {
    color: #718096;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .quiz-container {
        margin: 1rem auto;
        padding: 0 0.5rem;
    }
    
    .quiz-title {
        font-size: 1.5rem;
    }
    
    .quiz-header {
        padding: 1.5rem 1rem;
    }
    
    .quiz-info {
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem 1rem;
    }
    
    .info-item {
        flex-direction: row;
        justify-content: center;
        gap: 1rem;
    }
    
    .instructions {
        padding: 1.5rem 1rem;
    }
    
    .quiz-action {
        padding: 1.5rem 1rem;
    }
    
    .start-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .quiz-title {
        font-size: 1.2rem;
    }
    
    .info-item {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .start-btn {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const readyCheck = document.getElementById('readyCheck');
    const startBtn = document.getElementById('startBtn');
    
    if (readyCheck && startBtn) {
        readyCheck.addEventListener('change', function() {
            startBtn.disabled = !this.checked;
        });
        
        startBtn.addEventListener('click', function() {
            if (!this.disabled) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Memulai...';
                this.disabled = true;
                window.location.href = '{{ route("quiz.start", $quiz->id) }}';
            }
        });
    }
});
</script>
@endsection