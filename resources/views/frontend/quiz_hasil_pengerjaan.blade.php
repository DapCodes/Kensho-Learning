@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="card bg-gradient-success shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Terimakasih sudah mengerjakan!!</h3>
                        <p class="text-white-75 mb-3">Semua jawaban anda sudah tersimpan di database kami!!</p>
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
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-results"
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
                    <span class="badge bg-success fs-6">
                        <i class="ti ti-check me-1"></i>Selesai
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-primary mb-3">{{ $hasil->quiz->judul_quiz }} -
                            ({{ $hasil->quiz->mataPelajaran->nama_mapel }})</h4>
                        @if ($hasil->quiz->deskripsi)
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
                                <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-calendar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Tanggal Ujian</h6>
                                    <span
                                        class="text-muted">{{ \Carbon\Carbon::parse($hasil->updated_at)->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clock text-white"></i>
                                </div>
                                @php
                                    $totalDetik = round($hasil->waktu_pengerjaan * 60);
                                    $menit = floor($totalDetik / 60);
                                    $detik = $totalDetik % 60;
                                @endphp

                                <div>
                                    <h6 class="mb-0">Waktu Pengerjaan</h6>
                                    <span class="text-muted">
                                        {{ $hasil->quiz->status === 'Privat' ? '-' : $menit . ':' . str_pad($detik, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-list-numbers text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Soal</h6>
                                    <span class="text-muted">
                                        {{ $hasil->quiz->status === 'Privat' || !$hasil->detail ? '-' : $hasil->detail->count() . ' pertanyaan' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="row mb-4">
            @if ($hasil->quiz->status !== 'Privat')
                <!-- Score Card -->
                <div class="col-md-3">
                    <div class="card border-0 bg-gradient-primary text-white">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="ti ti-trophy" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-2 text-white">{{ $hasil->quiz->status === 'Privat' ? '-' : $hasil->skor }}
                            </h2>
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
                            <h2 class="fw-bold mb-2 text-white">
                                {{ $hasil->quiz->status === 'Privat' ? '-' : $hasil->jumlah_benar }}</h2>
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
                            <h2 class="fw-bold mb-2 text-white">
                                {{ $hasil->quiz->status === 'Privat' ? '-' : $hasil->jumlah_salah }}</h2>
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
            @endif
        </div>

        <!-- Top Performers -->
        @if ($hasil->quiz->status === 'Umum')
            @if (isset($top_performers) && count($top_performers) > 0)
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
                                    @foreach ($top_performers as $index => $performer)
                                        <tr class="{{ $performer->id == $hasil->id ? 'table-success' : '' }}">
                                            <td>
                                                @if ($index == 0)
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
                                                @if ($performer->id == $hasil->id)
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
        @endif

        <!-- Detail Jawaban Section - Improved Version -->
        @if ($hasil->quiz->status === 'Umum' && $hasil_detail->isNotEmpty())
            <div class="card border-0 mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-list-details me-2 text-primary"></i>
                            Detail Jawaban Anda
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="toggleAllAnswers()">
                                <i class="ti ti-eye me-1"></i>
                                <span id="toggleText">Sembunyikan Semua</span>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="filterAnswers('all')"
                                id="filterAll">
                                <i class="ti ti-list me-1"></i>Semua
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="filterAnswers('correct')"
                                id="filterCorrect">
                                <i class="ti ti-check me-1"></i>Benar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="filterAnswers('wrong')"
                                id="filterWrong">
                                <i class="ti ti-x me-1"></i>Salah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Summary Statistics -->
                    <div class="p-3 bg-light border-bottom">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-list-numbers text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Soal</h6>
                                        <span class="text-muted">{{ $hasil_detail->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-check-circle text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Jawaban Benar</h6>
                                        <span class="text-success fw-bold">{{ $hasil->jumlah_benar }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-x-circle text-danger fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Jawaban Salah</h6>
                                        <span class="text-danger fw-bold">{{ $hasil->jumlah_salah }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-percentage text-info fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Akurasi</h6>
                                        <span
                                            class="text-info fw-bold">{{ round(($hasil->jumlah_benar / $hasil_detail->count()) * 100) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="px-3 py-2 bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Progress Pengerjaan</small>
                            <small class="text-muted">{{ $hasil->jumlah_benar }}/{{ $hasil_detail->count() }}
                                benar</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ ($hasil->jumlah_benar / $hasil_detail->count()) * 100 }}%"
                                aria-valuenow="{{ ($hasil->jumlah_benar / $hasil_detail->count()) * 100 }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Question Details -->
                    <div class="question-container">
                        @foreach ($hasil_detail as $index => $detail)
                            <div class="question-item border-bottom {{ $detail->status_jawaban === 'benar' ? 'correct-answer' : 'wrong-answer' }}"
                                data-status="{{ $detail->status_jawaban }}">
                                <div class="p-3">
                                    <!-- Question Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="question-number me-3">
                                                <div class="badge {{ $detail->status_jawaban === 'benar' ? 'bg-success' : 'bg-danger' }} rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px; font-size: 14px;">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold">Soal {{ $index + 1 }}</h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($detail->status_jawaban === 'benar')
                                                        <span class="badge bg-success-subtle text-success">
                                                            <i class="ti ti-check me-1"></i>Benar
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'benar')
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ti ti-x me-1"></i>Salah
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'pending')
                                                        <span class="badge bg-info-subtle text-dark">
                                                            <i class="ti ti-time me-1"></i>pending
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'sebagian')
                                                        <span class="badge bg-info-subtle text-dark">
                                                            sebagian
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ti ti-x me-1"></i>tidak terjawab
                                                        </span>
                                                    @endif
                                                    <span class="badge bg-light text-muted">
                                                        <i class="ti ti-star me-1"></i>Bobot:
                                                        {{ $detail->bobot_diperoleh }} / {{ $detail->bobot_soal }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-link text-muted toggle-detail"
                                            onclick="toggleQuestionDetail({{ $index }})">
                                            <i class="ti ti-chevron-up" id="toggle-icon-{{ $index }}"></i>
                                        </button>
                                    </div>

                                    <!-- Question Content -->
                                    <div class="question-content" id="question-content-{{ $index }}">
                                        <!-- Question Text -->
                                        <div class="question-text mb-3">
                                            <label class="form-label fw-semibold text-dark">Pertanyaan:</label>
                                            <div class="p-3 bg-light rounded border-start border-4 border-primary">
                                                {!! $detail->soal->pertanyaan ?? '-' !!}
                                            </div>
                                        </div>

                                        <!-- Answer Section -->

                                        <div class="row">
                                            <!-- Your Answer -->
                                            <div
                                                class="{{ $detail->soal->tipe === 'essay' ? 'col-md-12' : 'col-md-6' }} mb-3">
                                                <label class="form-label fw-semibold">Jawaban Anda:</label>
                                                <div
                                                    class="answer-box p-3 rounded border-start border-4 
    @if ($detail->soal->tipe === 'essay') bg-info-subtle border-info 
    @else 
        {{ $detail->status_jawaban === 'benar' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger' }} @endif">

                                                    <div class="d-flex align-items-center">
                                                        <i
                                                            class="ti 
    @if ($detail->status_jawaban === 'pending') ti-clock text-info 
    @else 
        {{ $detail->status_jawaban === 'benar' ? 'ti-check text-success' : 'ti-x text-danger' }} @endif me-2 fs-5"></i>

                                                        <div class="flex-grow-1">
                                                            @if ($detail->jawaban_peserta)
                                                                @if ($detail->soal->tipe === 'essay')
                                                                    <div class="fw-medium">
                                                                        @if ($detail->status_jawaban === 'pending')
                                                                            <span class="badge bg-info">Essay - Sedang
                                                                                Dikoreksi</span>
                                                                        @endif

                                                                        @if ($detail->status_jawaban === 'benar' || $detail->status_jawaban === 'salah')
                                                                            <small class="text-muted">Jawaban essay sudah
                                                                                dikoreksi</small>
                                                                        @else
                                                                            <div class="mt-2">
                                                                                <small class="text-muted">Jawaban essay
                                                                                    akan dikoreksi secara manual oleh
                                                                                    pemilik quiz</small>
                                                                            </div>
                                                                        @endif


                                                                    </div>
                                                                @elseif($detail->soal->tipe === 'checkbox')
                                                                    @php
                                                                        $selectedAnswers = is_array(
                                                                            $detail->jawaban_peserta,
                                                                        )
                                                                            ? $detail->jawaban_peserta
                                                                            : explode(',', $detail->jawaban_peserta);
                                                                    @endphp
                                                                    <div class="fw-medium">
                                                                        @if (is_array($selectedAnswers) && count($selectedAnswers) > 0)
                                                                            @foreach ($selectedAnswers as $answer)
                                                                                <span
                                                                                    class="badge bg-primary me-1">{{ $answer }}</span>
                                                                            @endforeach
                                                                        @else
                                                                            <span class="text-muted">Tidak ada pilihan yang
                                                                                dipilih</span>
                                                                        @endif
                                                                    </div>
                                                                @elseif($detail->soal->tipe === 'benar_salah')
                                                                    <span class="fw-medium">
                                                                        @if ($detail->jawaban_peserta === 'Benar')
                                                                            <span class="badge bg-success">Benar</span>
                                                                        @else
                                                                            <span class="badge bg-danger">Salah</span>
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    {{-- Pilihan Ganda atau tipe lainnya --}}
                                                                    <span
                                                                        class="fw-medium">{{ $detail->jawaban_peserta }}</span>
                                                                @endif
                                                            @else
                                                                <span class="fw-medium text-muted">Tidak dijawab</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Correct Answer -->
                                            @if ($detail->soal->tipe !== 'essay')
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Jawaban Benar:</label>
                                                    <div
                                                        class="answer-box p-3 rounded border-start border-4 bg-success-subtle border-success">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ti ti-check text-success me-2 fs-5"></i>
                                                            <div class="flex-grow-1">
                                                                @if ($detail->soal->jawaban_benar)
                                                                    @if ($detail->soal->tipe === 'checkbox')
                                                                        @php
                                                                            $correctAnswers = is_array(
                                                                                $detail->soal->jawaban_benar,
                                                                            )
                                                                                ? $detail->soal->jawaban_benar
                                                                                : explode(
                                                                                    ',',
                                                                                    $detail->soal->jawaban_benar,
                                                                                );
                                                                        @endphp
                                                                        <div class="fw-medium">
                                                                            @if (is_array($correctAnswers) && count($correctAnswers) > 0)
                                                                                @foreach ($correctAnswers as $answer)
                                                                                    <span
                                                                                        class="badge bg-success me-1">{{ $answer }}</span>
                                                                                @endforeach
                                                                            @else
                                                                                <span class="text-muted">Tidak ada jawaban
                                                                                    benar yang ditetapkan</span>
                                                                            @endif
                                                                        </div>
                                                                    @elseif($detail->soal->tipe === 'benar_salah')
                                                                        <span class="fw-medium">
                                                                            @if ($detail->soal->jawaban_benar === 'Benar')
                                                                                <span class="badge bg-success">Benar</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Salah</span>
                                                                            @endif
                                                                        </span>
                                                                    @else
                                                                        {{-- Pilihan Ganda atau tipe lainnya --}}
                                                                        <span
                                                                            class="fw-medium">{{ $detail->soal->jawaban_benar }}</span>
                                                                    @endif
                                                                @else
                                                                    <span class="fw-medium text-muted">-</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="text-center p-5 d-none">
                        <i class="ti ti-search-off text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">Tidak ada hasil yang sesuai dengan filter</h5>
                        <p class="text-muted">Coba ubah filter untuk melihat soal lainnya</p>
                    </div>
                </div>
            </div>

            <script>
                // Toggle question detail visibility
                function toggleQuestionDetail(index) {
                    const content = document.getElementById(`question-content-${index}`);
                    const icon = document.getElementById(`toggle-icon-${index}`);

                    if (content.style.display === 'none') {
                        content.style.display = 'block';
                        icon.classList.remove('ti-chevron-down');
                        icon.classList.add('ti-chevron-up');
                    } else {
                        content.style.display = 'none';
                        icon.classList.remove('ti-chevron-up');
                        icon.classList.add('ti-chevron-down');
                    }
                }

                // Toggle all answers visibility
                function toggleAllAnswers() {
                    const allContent = document.querySelectorAll('[id^="question-content-"]');
                    const toggleText = document.getElementById('toggleText');
                    const allIcons = document.querySelectorAll('[id^="toggle-icon-"]');

                    const firstContent = allContent[0];
                    const isVisible = firstContent.style.display !== 'none';

                    allContent.forEach(content => {
                        content.style.display = isVisible ? 'none' : 'block';
                    });

                    allIcons.forEach(icon => {
                        if (isVisible) {
                            icon.classList.remove('ti-chevron-up');
                            icon.classList.add('ti-chevron-down');
                        } else {
                            icon.classList.remove('ti-chevron-down');
                            icon.classList.add('ti-chevron-up');
                        }
                    });

                    toggleText.textContent = isVisible ? 'Tampilkan Semua' : 'Sembunyikan Semua';
                }

                // Filter answers by type
                function filterAnswers(type) {
                    const questions = document.querySelectorAll('.question-item');
                    const noResults = document.getElementById('no-results');
                    const filterButtons = document.querySelectorAll('[id^="filter"]');
                    let visibleCount = 0;

                    // Remove active class from all filter buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    document.getElementById(`filter${type.charAt(0).toUpperCase() + type.slice(1)}`).classList.add('active');

                    questions.forEach(question => {
                        const status = question.getAttribute('data-status');
                        let shouldShow = false;

                        switch (type) {
                            case 'all':
                                shouldShow = true;
                                break;
                            case 'correct':
                                shouldShow = status === 'benar';
                                break;
                            case 'wrong':
                                shouldShow = status === 'salah';
                                break;
                        }

                        if (shouldShow) {
                            question.style.display = 'block';
                            visibleCount++;
                        } else {
                            question.style.display = 'none';
                        }
                    });

                    // Show/hide no results message
                    if (visibleCount === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                }

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    // Set initial filter to 'all'
                    document.getElementById('filterAll').classList.add('active');

                    // Animate question items
                    const questionItems = document.querySelectorAll('.question-item');
                    questionItems.forEach((item, index) => {
                        item.style.animationDelay = `${index * 0.05}s`;
                        item.classList.add('fade-in-question');
                    });
                });
            </script>

            <style>
                /* Question Detail Styles */
                .question-item {
                    transition: all 0.3s ease;
                    opacity: 0;
                    transform: translateY(10px);
                }

                .question-item.fade-in-question {
                    opacity: 1;
                    transform: translateY(0);
                }

                .question-item:hover {
                    background-color: #f8f9fa;
                }

                .question-number {
                    flex-shrink: 0;
                }

                .question-content {
                    transition: all 0.3s ease;
                }

                .answer-box {
                    transition: all 0.2s ease;
                }

                .answer-box:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .toggle-detail {
                    border: none !important;
                    padding: 0.25rem 0.5rem;
                    transition: all 0.2s ease;
                }

                .toggle-detail:hover {
                    background-color: #e9ecef;
                    border-radius: 0.375rem;
                }

                /* Filter Button Styles */
                .btn-outline-primary.active,
                .btn-outline-success.active,
                .btn-outline-danger.active,
                .btn-outline-secondary.active {
                    background-color: var(--bs-primary);
                    border-color: var(--bs-primary);
                    color: white;
                }

                .btn-outline-success.active {
                    background-color: var(--bs-success);
                    border-color: var(--bs-success);
                }

                .btn-outline-danger.active {
                    background-color: var(--bs-danger);
                    border-color: var(--bs-danger);
                }

                .btn-outline-secondary.active {
                    background-color: var(--bs-secondary);
                    border-color: var(--bs-secondary);
                }

                /* Background Subtle Colors */
                .bg-success-subtle {
                    background-color: rgba(25, 135, 84, 0.1) !important;
                }

                .bg-danger-subtle {
                    background-color: rgba(220, 53, 69, 0.1) !important;
                }

                .bg-info-subtle {
                    background-color: rgba(13, 202, 240, 0.1) !important;
                }

                .text-success {
                    color: #198754 !important;
                }

                .text-danger {
                    color: #dc3545 !important;
                }

                .text-info {
                    color: #0dcaf0 !important;
                }

                /* Border Colors */
                .border-success {
                    border-color: #198754 !important;
                }

                .border-danger {
                    border-color: #dc3545 !important;
                }

                .border-info {
                    border-color: #0dcaf0 !important;
                }

                /* Progress Bar Animation */
                .progress-bar {
                    transition: width 1.5s ease-in-out;
                }

                /* Responsive Design */
                @media (max-width: 768px) {
                    .d-flex.gap-2 {
                        flex-wrap: wrap;
                    }

                    .btn-sm {
                        margin-bottom: 0.25rem;
                    }

                    .question-number {
                        margin-bottom: 1rem;
                    }

                    .col-md-6 {
                        margin-bottom: 1rem;
                    }
                }

                /* Animation Keyframes */
                @keyframes fadeInQuestion {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .fade-in-question {
                    animation: fadeInQuestion 0.5s ease forwards;
                }
            </style>
        @endif

        <!-- end -->

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <a href="{{ route('dasbor') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
            </a>
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

            .btn,
            .breadcrumb {
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
