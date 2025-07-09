@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">

        <!-- Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Detail Quiz</h3>
                        <p class="text-white-75 mb-3">Lihat informasi lengkap dan semua soal quiz</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-dashboard"
                                class="img-fluid" style="max-height: 120px; filter: brightness(1.1);" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="position-absolute top-0 end-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
            </div>
            <div class="position-absolute bottom-0 start-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
            </div>
        </div>

        <!-- Quiz Information -->
        <div class="card border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Informasi Quiz</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit Quiz
                    </a>
                    <span class="badge {{ $quiz->status == 'published' ? 'bg-success' : 'bg-secondary' }} fs-6">
                        {{ ucfirst($quiz->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-primary mb-3">{{ $quiz->judul_quiz }} - ({{ $quiz->kategori->nama_kategori }})</h4>
                        @if ($quiz->deskripsi)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Deskripsi:</h6>
                                <p class="text-dark">{{ $quiz->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clock text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Durasi</h6>
                                    <span class="text-muted">{{ $quiz->waktu_menit }} menit</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-list-numbers text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Soal</h6>
                                    <span class="text-muted">{{ $quiz->soals->count() }} pertanyaan</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-3  d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-calendar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Dibuat</h6>
                                    <span class="text-muted">{{ $quiz->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Soal Quiz</h5>
            </div>
            <div class="card-body">
                @if ($quiz->soals->count() > 0)
                    @foreach ($quiz->soals as $index => $soal)
                        <div class="question-item card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0 text-primary">
                                    <i class="ti ti-help-circle me-2"></i>Soal {{ $index + 1 }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="text-dark mb-2">Pertanyaan:</h6>
                                    <p class="text-dark fs-6 bg-light p-3 rounded">{{ $soal->pertanyaan }}</p>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div
                                            class="option-item d-flex align-items-center mb-2 p-2 rounded {{ $soal->jawaban_benar == 'A' ? 'bg-success-subtle border border-success' : 'bg-light' }}">
                                            <span
                                                class="badge {{ $soal->jawaban_benar == 'A' ? 'bg-success' : 'bg-secondary' }} me-3">A</span>
                                            <span class="text-dark">{{ $soal->pilihan_a }}</span>
                                            @if ($soal->jawaban_benar == 'A')
                                                <i class="ti ti-check text-success ms-auto fs-5"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="option-item d-flex align-items-center mb-2 p-2 rounded {{ $soal->jawaban_benar == 'B' ? 'bg-success-subtle border border-success' : 'bg-light' }}">
                                            <span
                                                class="badge {{ $soal->jawaban_benar == 'B' ? 'bg-success' : 'bg-secondary' }} me-3">B</span>
                                            <span class="text-dark">{{ $soal->pilihan_b }}</span>
                                            @if ($soal->jawaban_benar == 'B')
                                                <i class="ti ti-check text-success ms-auto fs-5"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div
                                            class="option-item d-flex align-items-center mb-2 p-2 rounded {{ $soal->jawaban_benar == 'C' ? 'bg-success-subtle border border-success' : 'bg-light' }}">
                                            <span
                                                class="badge {{ $soal->jawaban_benar == 'C' ? 'bg-success' : 'bg-secondary' }} me-3">C</span>
                                            <span class="text-dark">{{ $soal->pilihan_c }}</span>
                                            @if ($soal->jawaban_benar == 'C')
                                                <i class="ti ti-check text-success ms-auto fs-5"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="option-item d-flex align-items-center mb-2 p-2 rounded {{ $soal->jawaban_benar == 'D' ? 'bg-success-subtle border border-success' : 'bg-light' }}">
                                            <span
                                                class="badge {{ $soal->jawaban_benar == 'D' ? 'bg-success' : 'bg-secondary' }} me-3">D</span>
                                            <span class="text-dark">{{ $soal->pilihan_d }}</span>
                                            @if ($soal->jawaban_benar == 'D')
                                                <i class="ti ti-check text-success ms-auto fs-5"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <small class="text-muted">
                                        <i class="ti ti-check-circle text-success me-1"></i>
                                        Jawaban benar: <strong>{{ $soal->jawaban_benar }}</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="ti ti-file-text text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Soal</h5>
                        <p class="text-muted mb-3">Quiz ini belum memiliki soal. Tambahkan soal untuk melengkapi quiz.</p>
                        <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>Tambah Soal
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning">
                    <i class="ti ti-edit me-2"></i>Edit Quiz
                </a>
                @if ($quiz->status == 'published')
                    <button class="btn btn-success" onclick="shareQuiz()">
                        <i class="ti ti-share me-2"></i>Bagikan Quiz
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionItems = document.querySelectorAll('.question-item');

            questionItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('fade-in');
            });
        });
    </script>

    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .question-item {
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .question-item.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .question-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .option-item {
            transition: all 0.2s ease;
        }

        .option-item:hover {
            transform: translateX(5px);
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background-color: #ffb300;
            border-color: #ffb300;
            color: #000;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-direction: column;
            }

            .d-flex.gap-2 .btn {
                margin-bottom: 0.5rem;
            }

            .col-md-6 .option-item {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
