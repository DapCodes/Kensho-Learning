@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Data Nilai Ujian</h3>
                        <p class="text-white-75 mb-3">Kelola dan pantau semua hasil ujian peserta dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="{{ route('admin.quiz-terbaru') }}">
                                        <i class="ti ti-home me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-assessment me-1"></i>Penilaian
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Data Nilai</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="data-nilai-dashboard"
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

        <!-- Enhanced Statistics Section -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px;">
                                <i class="ti ti-users text-primary" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $hasilUjians->count() }}</h4>
                                <p class="text-muted mb-0">Total Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px;">
                                <i class="ti ti-check text-success" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $hasilUjians->count() }}</h4>
                                <p class="text-muted mb-0">Ujian Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px;">
                                <i class="ti ti-star text-warning" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">
                                    {{ $hasilUjians->where('skor', '>', 0)->count() > 0 ? number_format($hasilUjians->where('skor', '>', 0)->avg('skor'), 1) : '0' }}
                                </h4>
                                <p class="text-muted mb-0">Rata-rata Nilai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                                style="width: 48px; height: 48px;">
                                <i class="ti ti-file-text text-info" style="font-size: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $hasilUjians->groupBy('quiz_id')->count() }}</h4>
                                <p class="text-muted mb-0">Quiz Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="ti ti-filter text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Filter Data Nilai</h5>
                        <p class="text-muted mb-0">Pilih quiz untuk menampilkan data nilai yang spesifik</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('penilaian.dataNilai') }}" id="filterForm">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label for="quiz_filter" class="form-label fw-bold">
                                <i class="ti ti-file-text me-1"></i>Filter berdasarkan Quiz
                            </label>
                            <select name="quiz_filter" id="quiz_filter" class="form-select form-select-lg" onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ $quizFilter === 'all' || !$quizFilter ? 'selected' : '' }}>
                                    <i class="ti ti-list"></i> Semua Quiz
                                </option>
                                @foreach($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}" {{ $quizFilter == $quiz->id ? 'selected' : '' }}>
                                        {{ $quiz->judul_quiz }} ({{ $quiz->kode_quiz }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="ti ti-search me-2"></i>Filter
                                </button>
                                <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="ti ti-refresh me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Summary -->
                    @if($quizFilter && $quizFilter !== 'all')
                        @php
                            $selectedQuiz = $quizzes->firstWhere('id', $quizFilter);
                        @endphp
                        <div class="mt-3">
                            <div class="alert alert-info d-flex align-items-center mb-0">
                                <i class="ti ti-info-circle me-2"></i>
                                <div>
                                    <strong>Filter Aktif:</strong> 
                                    Menampilkan data nilai untuk quiz "{{ $selectedQuiz->judul_quiz }}" 
                                    <span class="badge bg-info ms-2">{{ $selectedQuiz->kode_quiz }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Enhanced Action Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clipboard-data text-success"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Data Nilai Peserta</h5>
                                <p class="text-muted mb-0">
                                    @if ($hasilUjians->count() > 0)
                                        @if($quizFilter && $quizFilter !== 'all')
                                            Menampilkan {{ $hasilUjians->count() }} hasil ujian untuk quiz yang dipilih
                                        @else
                                            Menampilkan {{ $hasilUjians->count() }} hasil ujian dari semua quiz
                                        @endif
                                    @else
                                        Belum ada data nilai - peserta belum mengerjakan quiz
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Export Button Component -->
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        

                            <div class="col-md-12 text-md-end mt-3 mt-md-0">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('penilaian.dataNilai', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-success btn-lg px-4">
                                       Export Excel
                                    </a>
                                    <a href="{{ route('penilaian.dataNilai', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger btn-lg px-4">
                                            Export PDF
                                    </a>
                                </div>
                            </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Data Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-table me-2 text-success"></i>Tabel Data Nilai
                    </h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success-subtle text-success px-3 py-2">
                            {{ $hasilUjians->count() }} Data Tersedia
                        </span>
                    </div>
                </div>
            </div>

            @if ($hasilUjians->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-hash me-1"></i>No
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-user me-1"></i>Peserta
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="ti ti-file-text me-1"></i>Quiz
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="ti ti-calendar me-1"></i>Tanggal Ujian
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="ti ti-clock me-1"></i>Durasi
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="ti ti-star me-1"></i>Nilai
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="ti ti-check me-1"></i>Status
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        Koreksi Essay
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                        <i class="ti ti-settings me-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilUjians as $index => $hasil)
                                    <tr class="hasil-row">
                                        <td class="py-4">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <span class="fw-bold text-primary">{{ $loop->iteration }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="ti ti-user text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark">{{ $hasil->user->name }}</h6>
                                                    <small class="text-muted">{{ $hasil->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark"
                                                    title="{{ $hasil->quiz->judul_quiz }}">
                                                    {{ Str::limit($hasil->quiz->judul_quiz, 30) }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="ti ti-key me-1"></i>{{ $hasil->quiz->kode_quiz }}
                                                </small>
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <i class="ti ti-book me-1"></i>{{ $hasil->quiz->mataPelajaran->nama_mapel }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fw-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($hasil->tanggal_ujian)->format('d M Y') }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($hasil->updated_at)->format('H:i') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="ti ti-clock text-warning" style="font-size: 14px;"></i>
                                                </div>
                                                @php
                                                    $totalDetik = round($hasil->waktu_pengerjaan * 60);
                                                    $menit = floor($totalDetik / 60);
                                                    $detik = $totalDetik % 60;
                                                @endphp
                                                <span class="text-muted">{{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}</span>
                                                <small class="text-muted ms-1">min</small>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                @php
                                                    $badgeClass = 'secondary';
                                                    if ($hasil->skor >= 80) {
                                                        $badgeClass = 'success';
                                                    } elseif ($hasil->skor >= 70) {
                                                        $badgeClass = 'info';
                                                    } elseif ($hasil->skor >= 60) {
                                                        $badgeClass = 'warning';
                                                    } elseif ($hasil->skor > 0) {
                                                        $badgeClass = 'danger';
                                                    }
                                                @endphp
                                                <span class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }} px-3 py-2 fw-bold">
                                                    <i class="ti ti-star me-1"></i>{{ $hasil->skor ?? 'Belum Dinilai' }}
                                                </span>
                                            </div>
                                        </td>
                                        @php
                                            // Periksa apakah ada essay yang perlu dikoreksi
                                            $hasEssayNeedingGrading = $hasil->detail->contains(function ($d) {
                                                return $d->soal->tipe === 'essay' && $d->status_jawaban === 'pending';
                                            });

                                            // Periksa apakah semua essay sudah dikoreksi
                                            $allEssaysGraded = $hasil->detail
                                                ->filter(fn($d) => $d->soal->tipe === 'essay')
                                                ->every(fn($d) => $d->status_jawaban !== 'pending');

                                            // Periksa apakah user yang login adalah pembuat quiz
                                            $canGrade = $hasil->quiz->user_id === Auth::id();
                                        @endphp

                                        <td class="py-4 text-center">
                                            @if ($hasEssayNeedingGrading)
                                                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                                    <i class="ti ti-clock me-1"></i>
                                                    Perlu Koreksi
                                                </span>
                                            @elseif ($allEssaysGraded)
                                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                                    <i class="ti ti-check-circle me-1"></i>
                                                    Sudah Dikoreksi
                                                </span>
                                            @else
                                                <span class="badge bg-info-subtle text-info px-3 py-2">
                                                    <i class="ti ti-info-circle me-1"></i>
                                                    Tidak Ada Essay
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-4 text-center">
                                            @if ($canGrade && $hasEssayNeedingGrading)
                                                <div class="mt-2">
                                                    <a href="{{ route('penilaian.show', $hasil->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-pencil"></i> Koreksi Essay
                                                    </a>
                                                </div>
                                            @elseif (!$canGrade)
                                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                                    <i class="ti ti-lock me-1"></i>
                                                    Tidak Ada Akses
                                                </span>
                                            @else
                                                <div class="mt-2">
                                                    <a href="{{ route('penilaian.show', $hasil->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-pencil"></i> Koreksi Essay
                                                    </a>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-4 text-center pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('penilaian.detail', $hasil->id) }}"
                                                    class="btn btn-info btn-sm" title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if ($hasil->quiz->soals->where('jenis_soal', 'essay')->count() > 0)
                                                    <a href="{{ route('penilaian.index') }}?hasil_id={{ $hasil->id }}"
                                                        class="btn btn-warning btn-sm" title="Beri Nilai Essay">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endif

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-download"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('penilaian.detail', ['id' => $hasil->id, 'export' => 'excel']) }}">
                                                                <i class="fas fa-file-excel me-2 text-success"></i>Export ke Excel
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('penilaian.detail', ['id' => $hasil->id, 'export' => 'pdf']) }}">
                                                                <i class="fas fa-file-pdf me-2 text-danger"></i>Export ke PDF
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="ti ti-clipboard-data text-success" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">
                        @if($quizFilter && $quizFilter !== 'all')
                            Belum Ada Data Nilai untuk Quiz Ini
                        @else
                            Belum Ada Data Nilai
                        @endif
                    </h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        @if($quizFilter && $quizFilter !== 'all')
                            Belum ada peserta yang mengerjakan quiz yang dipilih. Bagikan kode quiz kepada peserta untuk mulai mendapatkan data nilai.
                        @else
                            Belum ada peserta yang mengerjakan quiz Anda. Bagikan kode quiz kepada peserta untuk mulai mendapatkan data nilai.
                        @endif
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        @if($quizFilter && $quizFilter !== 'all')
                            <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-outline-primary px-4">
                                <i class="ti ti-refresh me-2"></i>Lihat Semua Quiz
                            </a>
                        @endif
                        <a href="{{ route('quiz.index') }}" class="btn btn-success px-5">
                            <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Toast Messages -->
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="ti ti-check text-success" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Berhasil</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="ti ti-x text-danger" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif


<script>
        // Enhanced Filter JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const quizFilter = document.getElementById('quiz_filter');
    const filterForm = document.getElementById('filterForm');
    
    // Auto-submit form when filter changes
    quizFilter.addEventListener('change', function() {
        // Show loading indicator
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
        loadingIndicator.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        loadingIndicator.style.zIndex = '9999';
        loadingIndicator.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted">Memuat data...</p>
            </div>
        `;
        document.body.appendChild(loadingIndicator);
        
        // Submit form
        filterForm.submit();
    });
    
    // Enhanced search functionality
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.className = 'form-control mb-3';
    searchInput.placeholder = 'Cari peserta, quiz, atau mata pelajaran...';
    searchInput.id = 'searchInput';
    
    // Add search input to the table card header
    const tableHeader = document.querySelector('.card-header');
    if (tableHeader) {
        const searchContainer = document.createElement('div');
        searchContainer.className = 'row align-items-center';
        searchContainer.innerHTML = `
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-table me-2 text-success"></i>Tabel Data Nilai
                </h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="form-control" placeholder="Cari peserta, quiz, atau mata pelajaran..." id="searchInput">
                    <span class="badge bg-success-subtle text-success px-3 py-2">
                        ${document.querySelectorAll('.hasil-row').length} Data Tersedia
                    </span>
                </div>
            </div>
        `;
        tableHeader.innerHTML = '';
        tableHeader.appendChild(searchContainer);
    }
    
    // Real-time search functionality
    const searchInputElement = document.getElementById('searchInput');
    if (searchInputElement) {
        searchInputElement.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.hasil-row');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const peserta = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const quiz = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const mapel = row.querySelector('td:nth-child(3) small').textContent.toLowerCase();
                
                if (peserta.includes(searchTerm) || quiz.includes(searchTerm) || mapel.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update counter
            const counter = document.querySelector('.badge');
            if (counter) {
                counter.textContent = `${visibleCount} Data Tersedia`;
            }
            
            // Show/hide empty state
            const tableBody = document.querySelector('tbody');
            const emptyState = document.querySelector('.empty-search-state');
            
            if (visibleCount === 0 && searchTerm !== '') {
                if (!emptyState) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.className = 'empty-search-state';
                    emptyRow.innerHTML = `
                        <td colspan="9" class="text-center py-5">
                            <div class="mb-3">
                                <i class="ti ti-search text-muted" style="font-size: 48px;"></i>
                            </div>
                            <h5 class="text-muted">Tidak Ada Data Ditemukan</h5>
                            <p class="text-muted">Tidak ada data yang cocok dengan pencarian "${searchTerm}"</p>
                        </td>
                    `;
                    tableBody.appendChild(emptyRow);
                }
            } else if (emptyState) {
                emptyState.remove();
            }
        });
    }
    
    // Toast auto-hide functionality
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        // Auto hide after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 5000);
    });
    
    // Enhanced table row hover effects
    const tableRows = document.querySelectorAll('.hasil-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
    
    // Initialize tooltips for action buttons
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Export button loading state
    const exportButtons = document.querySelectorAll('[href*="export"]');
    exportButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Exporting...';
            this.disabled = true;
            
            // Re-enable after 3 seconds
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    });
    
    // Smooth scrolling for long tables
    const tableContainer = document.querySelector('.table-responsive');
    if (tableContainer) {
        tableContainer.style.scrollBehavior = 'smooth';
    }
    
    // Enhanced mobile responsiveness
    function handleMobileView() {
        const table = document.querySelector('.table');
        const isMobile = window.innerWidth < 768;
        
        if (isMobile && table) {
            // Add mobile-friendly classes
            table.classList.add('table-sm');
            
            // Hide less important columns on mobile
            const lessImportantColumns = document.querySelectorAll('th:nth-child(4), td:nth-child(4), th:nth-child(5), td:nth-child(5)');
            lessImportantColumns.forEach(col => {
                col.style.display = isMobile ? 'none' : '';
            });
        }
    }
    
    // Initial mobile check
    handleMobileView();
    
    // Listen for window resize
    window.addEventListener('resize', handleMobileView);
    
    // Add confirmation for reset button
    const resetButton = document.querySelector('[href*="dataNilai"]:not([href*="export"])');
    if (resetButton && resetButton.textContent.includes('Reset')) {
        resetButton.addEventListener('click', function(e) {
            if (quizFilter.value !== 'all') {
                const confirmReset = confirm('Apakah Anda yakin ingin mereset filter dan menampilkan semua data?');
                if (!confirmReset) {
                    e.preventDefault();
                }
            }
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            if (searchInputElement) {
                searchInputElement.focus();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape' && searchInputElement) {
            searchInputElement.value = '';
            searchInputElement.dispatchEvent(new Event('input'));
        }
    });
    
    // Initialize page with animations
    function initializePageAnimations() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
    
    // Initialize animations
    initializePageAnimations();
    
    // REMOVED: Custom dropdown functionality that was interfering with Bootstrap
    // Bootstrap will handle dropdown functionality automatically
    
    // Add loading state to filter form
    filterForm.addEventListener('submit', function() {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Memuat...';
            submitButton.disabled = true;
        }
    });
    
    // Status badge click for more info
    const statusBadges = document.querySelectorAll('.badge');
    statusBadges.forEach(badge => {
        if (badge.textContent.includes('Perlu Koreksi')) {
            badge.style.cursor = 'pointer';
            badge.title = 'Klik untuk melihat detail essay yang perlu dikoreksi';
        }
    });
    
    console.log('Enhanced filter script loaded successfully!');
});
</script>

    @include('layouts.components-backend.css')
@endsection
