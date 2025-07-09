@extends('layouts.backend')
@section('content')
@include('layouts.components-backend.css')
<div class="container-fluid">
    
    <!-- Header Section -->
    <div class="card bg-gradient-success shadow-sm position-relative overflow-hidden mb-5 border-0">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Hasil Ujian</h3>
                    <p class="text-white-75 mb-3">Lihat hasil ujian dan posisi peringkat Anda</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="">
                                    <i class="ti ti-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Hasil</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <img src="{{asset('assets/backend/images/breadcrumb/ChatBc.png')}}" 
                             alt="quiz-results" 
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

    <!-- Quiz Information -->
    <div class="card border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Informasi Quiz</h5>
            <div class="d-flex gap-2">
                <span class="badge bg-success fs-6">
                    <i class="ti ti-check me-1"></i>Selesai
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="text-primary mb-3">{{ $hasil->quiz->judul_quiz }} - ({{ $hasil->quiz->mataPelajaran->nama_mapel }})</h4>
                    @if($hasil->quiz->deskripsi)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Deskripsi:</h6>
                            <p class="text-dark">{{ $hasil->quiz->deskripsi }}</p>
                        </div>
                    @endif
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Peserta:</h6>
                        <p class="text-dark">{{ $hasil->user->name }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light rounded p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                <i class="ti ti-calendar text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tanggal Ujian</h6>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($hasil->updated_at)->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                <i class="ti ti-clock text-white"></i>
                            </div>
                            @php
                                $totalDetik = round($hasil->waktu_pengerjaan * 60);
                                $menit = floor($totalDetik / 60);
                                $detik = $totalDetik % 60;
                            @endphp

                            <div>
                                <h6 class="mb-0">Waktu Pengerjaan</h6>
                                <span class="text-muted">{{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>

                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                <i class="ti ti-list-numbers text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Soal</h6>
                                <span class="text-muted">{{ $hasil->jumlah_benar + $hasil->jumlah_salah }} pertanyaan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="row mb-4">
        <!-- Score Card -->
        <div class="col-md-3">
            <div class="card border-0 bg-gradient-primary text-white">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="ti ti-trophy" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">{{ $hasil->skor }}</h2>
                    <p class="mb-0">Skor Akhir</p>
                </div>
            </div>
        </div>
        
        <!-- Correct Answers Card -->
        <div class="col-md-3">
            <div class="card border-0 bg-gradient-success text-white">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="ti ti-check" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">{{ $hasil->jumlah_benar }}</h2>
                    <p class="mb-0">Jawaban Benar</p>
                </div>
            </div>
        </div>
        
        <!-- Wrong Answers Card -->
        <div class="col-md-3">
            <div class="card border-0 bg-gradient-danger text-white">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="ti ti-x" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">{{ $hasil->jumlah_salah }}</h2>
                    <p class="mb-0">Jawaban Salah</p>
                </div>
            </div>
        </div>
        
        <!-- Ranking Card -->
        <div class="col-md-3">
            <div class="card border-0 bg-gradient-warning text-white">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="ti ti-medal" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">{{ $ranking }}</h2>
                    <p class="mb-0">dari {{ $total_peserta }} peserta</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    @if(isset($top_performers) && count($top_performers) > 0)
    <div class="card border-0 mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Papan Peringkat</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama</th>
                            <th>Skor</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($top_performers as $index => $performer)
                        <tr class="{{ $performer->id == $hasil->id ? 'table-success' : '' }}">
                            <td>
                                @if($index == 0)
                                    <i class="ti ti-crown text-warning fs-5"></i>
                                @elseif($index == 1)
                                    <i class="ti ti-medal text-secondary fs-5"></i>
                                @elseif($index == 2)
                                    <i class="ti ti-award text-warning fs-5"></i>
                                @else
                                    <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $performer->user->name }}
                                @if($performer->id == $hasil->id)
                                    <small class="text-success fw-bold">(Anda)</small>
                                @endif
                            </td>
                            <td><span class="badge bg-primary">{{ $performer->skor }}</span></td>
                            <td><span class="text-success">{{ $performer->jumlah_benar }}</span></td>
                            <td><span class="text-danger">{{ $performer->jumlah_salah }}</span></td>
                            <td>
                                @php
                                    $totalDetik = round($performer->waktu_pengerjaan * 60);
                                    $menit = floor($totalDetik / 60);
                                    $detik = $totalDetik % 60;
                                @endphp

                                {{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- ujain detail -->
@if($hasil->quiz->status === 'Umum' && $hasil_detail->isNotEmpty())
<div class="card border-0 mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Detail Jawaban Anda</h5>
    </div>
    <div class="card-body">
        @foreach($hasil_detail as $index => $detail)
        <div class="card mb-3 shadow-sm border {{ $detail->status_jawaban === 'benar' ? 'border-success' : 'border-danger' }}">
            <div class="card-body">
                <h6 class="fw-bold">
                    Soal {{ $index + 1 }}
                    @if($detail->status_jawaban === 'benar')
                        <span class="badge bg-success ms-2"><i class="ti ti-check"></i> Benar</span>
                    @else
                        <span class="badge bg-danger ms-2"><i class="ti ti-x"></i> Salah</span>
                    @endif
                </h6>
                <p><strong>Pertanyaan:</strong> {!! $detail->soal->pertanyaan ?? '-' !!}</p>
                <p class="mb-1"><strong>Jawaban Anda:</strong> {{ $detail->jawaban_peserta ?? '-' }}</p>
                @if($detail->status_jawaban !== 'benar')
                    <p class="mb-0"><strong>Jawaban Benar:</strong> {{ $detail->soal->jawaban_benar ?? '-' }}</p>
                @endif
                <p class="text-muted small mb-0">Bobot: {{ $detail->bobot ?? 1 }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

    <!-- end -->

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <a href="{{ route('dasbor') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
        </a>
        <div class="d-flex gap-2">
            <button class="btn btn-success" onclick="printResult()">
                <i class="ti ti-printer me-2"></i>Cetak Hasil
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });

    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
});

function printResult() {
    window.print();
}

function shareResult() {
    if (navigator.share) {
        navigator.share({
            title: 'Hasil Quiz',
            text: 'Saya telah menyelesaikan quiz dan mendapat skor {{ $hasil->skor }}!',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link hasil telah disalin ke clipboard!');
        });
    }
}
</script>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.card.fade-in {
    opacity: 1;
    transform: translateY(0);
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ffa8a8 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
}

.progress {
    background-color: #e9ecef;
    border-radius: 0.5rem;
}

.progress-bar {
    transition: width 1s ease-in-out;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.table-success {
    background-color: rgba(25, 135, 84, 0.1);
}

.badge {
    font-size: 0.875em;
}

.text-primary {
    color: #0d6efd !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.rounded {
    border-radius: 0.375rem !important;
}

.fs-6 {
    font-size: 1rem !important;
}

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

/* Icon styles */
.ti {
    font-size: 1.2em;
}

/* Print styles */
@media print {
    .btn, .breadcrumb {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.gap-2 .btn {
        margin-bottom: 0.5rem;
    }
    
    .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection