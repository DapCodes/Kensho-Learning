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
                    <a class="btn btn-info btn-sm" href="{{ route('quiz.index', ['export' => 'pdf', 'quiz_id' => $quiz->id]) }}" title="Export PDF">
                        <i class="ti ti-file-text"></i>
                    </a>
                    <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit Quiz
                    </a>
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
                        @if ($quiz->mapel)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Mata Pelajaran:</h6>
                                <p class="text-dark">{{ $quiz->mapel->nama_mapel }}</p>
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
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-trophy text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Bobot</h6>
                                    <span class="text-muted">{{ $quiz->soals->sum('bobot') }} poin</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center"
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


                    @php
                        $questionTypes = [
                            'pilihan_ganda' => ['label' => 'Pilihan Ganda', 'icon' => 'ti-list', 'color' => 'primary'],
                            'essay' => ['label' => 'Essay', 'icon' => 'ti-file-text', 'color' => 'primary'],
                            'benar_salah' => ['label' => 'Benar/Salah', 'icon' => 'ti-x', 'color' => 'primary'],
                            'checkbox' => ['label' => 'Pilihan Ganda (Multiple)', 'icon' => 'ti-checkbox', 'color' => 'primary']
                        ];
                        
                        $typeStats = $quiz->soals->groupBy('tipe_soal')->map(function($questions) {
                            return $questions->count();
                        });
                    @endphp
                

        <!-- Questions Section -->
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Soal Quiz</h5>
                <div class="d-flex gap-2">
                    <span class="badge bg-primary">{{ $quiz->soals->count() }} Soal</span>
                    <span class="badge bg-success">{{ $quiz->soals->sum('bobot') }} Poin</span>
                </div>
            </div>
            <div class="card-body">
                @if ($quiz->soals->count() > 0)
                    @foreach ($quiz->soals as $index => $soal)
                        @php
                            $questionType = $soal->tipe;
                            $typeConfig = $questionTypes[$questionType] ?? $questionTypes['pilihan_ganda'];
                        @endphp
                        
                        <div class="question-item card mb-4" data-type="{{ $questionType }}">
                            <div class="card-header bg-{{ $typeConfig['color'] }}-subtle d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0 text-{{ $typeConfig['color'] }}">
                                        <i class="ti ti-help-circle me-2"></i>Soal {{ $index + 1 }}
                                    </h6>
                                    <small class="text-muted">
                                        Tipe: {{ $typeConfig['label'] }} | Bobot: {{ $soal->bobot ?? 1 }} poin
                                    </small>
                                </div>
                                <div class="question-type-icon">
                                    <i class="ti {{ $typeConfig['icon'] }} text-{{ $typeConfig['color'] }} fs-4"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="text-dark mb-2">Pertanyaan:</h6>
                                    <div class="question-text bg-light p-3 rounded">
                                        {!! nl2br(e($soal->pertanyaan)) !!}
                                    </div>
                                </div>

                                @switch($questionType)
                                    @case('pilihan_ganda')
                                        @include('backend.quiz.partials.pilihan-ganda', ['soal' => $soal])
                                        @break
                                    @case('essay')
                                        @include('backend.quiz.partials.essay', ['soal' => $soal])
                                        @break
                                    @case('benar_salah')
                                        @include('backend.quiz.partials.benar-salah', ['soal' => $soal])
                                        @break
                                    @case('checkbox')
                                        @include('backend.quiz.partials.checkbox', ['soal' => $soal])
                                        @break
                                    @default
                                        @include('backend.quiz.partials.pilihan-ganda', ['soal' => $soal])
                                @endswitch

                                <div class="text-end mt-3">
                                    <small class="text-muted">
                                        <i class="ti ti-check-circle text-success me-1"></i>
                                        Tipe: {{ $typeConfig['label'] }}
                                        @if($questionType !== 'essay')
                                            | Jawaban: 
                                            @if($questionType === 'checkbox')
                                                <span class="text-success">Multiple</span>
                                            @else
                                                <strong class="text-success">{{ $soal->jawaban_benar }}</strong>
                                            @endif
                                        @endif
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
                <a href="{{ route('quiz.index', ['export' => 'pdf', 'quiz_id' => $quiz->id]) }}" class="btn btn-danger" target="_blank">
                    <i class="ti ti-file-download me-2"></i>Cetak PDF
                </a>
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

        function shareQuiz() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $quiz->judul_quiz }}',
                    text: 'Ikuti quiz: {{ $quiz->judul_quiz }}',
                    url: window.location.href
                });
            } else {
                // Fallback untuk browser yang tidak mendukung Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link quiz telah disalin ke clipboard!');
                }).catch(() => {
                    // Jika clipboard API tidak didukung, gunakan metode lama
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Link quiz telah disalin ke clipboard!');
                });
            }
        }
    </script>

    @include('layouts.components-backend.css')

@endsection