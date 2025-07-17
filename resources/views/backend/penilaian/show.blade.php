@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Nilai Essay: {{ $hasilUjian->user->name }}</h3>
                        <p class="text-white-75 mb-3">Quiz: {{ $hasilUjian->quiz->judul_quiz }}</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="{{ route('penilaian.dataNilai') }}">
                                        <i class="ti ti-arrow-left me-1"></i>Penilaian
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Nilai Essay</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="grading-dashboard"
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
        </div>

        <!-- Student Information Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="ti ti-user text-success"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $hasilUjian->user->name }}</h5>
                                <p class="text-muted mb-0">{{ $hasilUjian->user->email }}</p>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>
                                    Ujian: {{ \Carbon\Carbon::parse($hasilUjian->tanggal_ujian)->format('d M Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="ti ti-clock me-1"></i>{{ $hasilUjian->waktu_pengerjaan }} menit
                            </span>
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="ti ti-percentage me-1"></i>{{ $hasilUjian->skor }}%
                            </span>
                        </div>
                        <!-- Reset Button -->
                        <div class="mt-2">
                            <a href="{{ route('penilaian.resetGrading', $hasilUjian->id) }}"
                                class="btn btn-sm btn-outline-warning"
                                onclick="return confirm('Apakah Anda yakin ingin mereset semua penilaian essay?')">
                                <i class="ti ti-refresh me-1"></i>Reset Penilaian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grading Form -->
        @if ($essayDetails->count() > 0)
            <form action="{{ route('penilaian.updateGrade', $hasilUjian->id) }}" method="POST" id="gradingForm">
                @csrf
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning-subtle border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-warning">
                            <i class="ti ti-edit me-2"></i>Essay Belum Dinilai ({{ $essayDetails->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($essayDetails as $index => $detail)
                            <div class="essay-item mb-5 p-4 border rounded-3 bg-light">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <h6 class="fw-bold text-dark mb-2">
                                                <i class="ti ti-help-circle me-1 text-primary"></i>
                                                Soal {{ $index + 1 }}
                                            </h6>
                                            <div class="p-3 bg-white rounded border">
                                                {!! nl2br(e($detail->soal->pertanyaan)) !!}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <h6 class="fw-bold text-dark mb-2">
                                                <i class="ti ti-pencil me-1 text-success"></i>
                                                Jawaban Peserta
                                            </h6>
                                            <div class="p-3 bg-white rounded border">
                                                @if ($detail->jawaban_peserta)
                                                    {!! nl2br(e($detail->jawaban_peserta)) !!}
                                                @else
                                                    <span class="text-muted fst-italic">Tidak ada jawaban</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="grading-section p-3 bg-white rounded border">
                                            <h6 class="fw-bold text-dark mb-3">
                                                <i class="ti ti-star me-1 text-primary"></i>
                                                Penilaian
                                            </h6>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Bobot Maksimal</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $detail->bobot_soal }}" readonly>
                                                    <span class="input-group-text">poin</span>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai yang Diberikan</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control grade-input"
                                                        name="grades[{{ $detail->id }}]" min="0"
                                                        max="{{ $detail->bobot_soal }}" step="0.01"
                                                        value="{{ old('grades.' . $detail->id, $detail->bobot_diperoleh ?? 0) }}"
                                                        required data-detail-id="{{ $detail->id }}"
                                                        data-max-grade="{{ $detail->bobot_soal }}">
                                                    <span class="input-group-text">poin</span>
                                                </div>
                                                <small class="text-muted">
                                                    Maksimal: {{ $detail->bobot_soal }} poin
                                                </small>
                                                <div class="invalid-feedback">
                                                    Nilai harus antara 0 dan {{ $detail->bobot_soal }}
                                                </div>
                                            </div>

                                            <div class="quick-grade-buttons">
                                                <label class="form-label fw-bold">Nilai Cepat</label>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger quick-grade-btn"
                                                        data-target="grades[{{ $detail->id }}]" data-value="0">
                                                        0%
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning quick-grade-btn"
                                                        data-target="grades[{{ $detail->id }}]"
                                                        data-value="{{ $detail->bobot_soal * 0.25 }}">
                                                        25%
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary quick-grade-btn"
                                                        data-target="grades[{{ $detail->id }}]"
                                                        data-value="{{ $detail->bobot_soal * 0.5 }}">
                                                        50%
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-info quick-grade-btn"
                                                        data-target="grades[{{ $detail->id }}]"
                                                        data-value="{{ $detail->bobot_soal * 0.75 }}">
                                                        75%
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-success quick-grade-btn"
                                                        data-target="grades[{{ $detail->id }}]"
                                                        data-value="{{ $detail->bobot_soal }}">
                                                        100%
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-end">
                            <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-secondary btn-lg me-2">
                                <i class="ti ti-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="ti ti-check me-2"></i>Simpan Penilaian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        <!-- Already Graded Essays -->
        @if ($gradedEssayDetails->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success-subtle border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="ti ti-check-circle me-2"></i>Essay Sudah Dinilai ({{ $gradedEssayDetails->count() }})
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach ($gradedEssayDetails as $index => $detail)
                        <div class="essay-item mb-4 p-4 border rounded-3 bg-light">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="ti ti-help-circle me-1 text-primary"></i>
                                            Soal {{ $index + 1 }}
                                        </h6>
                                        <div class="p-3 bg-white rounded border">
                                            {!! nl2br(e($detail->soal->pertanyaan)) !!}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="ti ti-pencil me-1 text-success"></i>
                                            Jawaban Peserta
                                        </h6>
                                        <div class="p-3 bg-white rounded border">
                                            @if ($detail->jawaban_peserta)
                                                {!! nl2br(e($detail->jawaban_peserta)) !!}
                                            @else
                                                <span class="text-muted fst-italic">Tidak ada jawaban</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="grading-section p-3 bg-white rounded border">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="ti ti-star me-1 text-primary"></i>
                                            Penilaian
                                        </h6>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bobot Maksimal</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $detail->bobot_soal }}" readonly>
                                                <span class="input-group-text">poin</span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nilai Diberikan</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $detail->bobot_diperoleh }}" readonly>
                                                <span class="input-group-text">poin</span>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="ti ti-check-circle me-1"></i>
                                                {{ $detail->bobot_soal > 0 ? round(($detail->bobot_diperoleh / $detail->bobot_soal) * 100, 1) : 0 }}%
                                            </span>
                                        </div>

                                        <!-- Edit Button for Already Graded -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- No Essays to Grade -->
        @if ($essayDetails->count() == 0 && $gradedEssayDetails->count() == 0)
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-info-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="ti ti-file-search text-info" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Tidak Ada Essay</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Hasil ujian ini tidak memiliki soal essay yang perlu dinilai.
                    </p>
                    <a href="{{ route('penilaian.dataNilai') }}" class="btn btn-primary btn-lg px-5">
                        <i class="ti ti-arrow-left me-2"></i>Kembali ke Penilaian
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Enhanced Toast Messages -->
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

    <!-- Edit Grade Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Nilai Essay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editGradeForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editGradeInput" class="form-label">Nilai Baru</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editGradeInput" name="grade"
                                    min="0" step="0.01" required>
                                <span class="input-group-text">poin</span>
                            </div>
                            <small class="text-muted">Maksimal: <span id="editMaxGrade"></span> poin</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .essay-item {
            transition: all 0.3s ease;
        }

        .essay-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quick-grade-btn {
            min-width: 60px;
        }

        .grade-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .toast {
            min-width: 300px;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }

        .breadcrumb-light .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quick grade buttons functionality
            document.querySelectorAll('.quick-grade-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetName = this.getAttribute('data-target');
                    const value = this.getAttribute('data-value');
                    const input = document.querySelector(`input[name="${targetName}"]`);

                    if (input) {
                        input.value = parseFloat(value).toFixed(2);
                        input.focus();

                        // Add visual feedback
                        this.classList.add('active');
                        setTimeout(() => this.classList.remove('active'), 200);
                    }
                });
            });

            // Grade input validation
            document.querySelectorAll('.grade-input').forEach(input => {
                input.addEventListener('input', function() {
                    const maxGrade = parseFloat(this.getAttribute('data-max-grade'));
                    const currentValue = parseFloat(this.value);

                    if (currentValue > maxGrade) {
                        this.value = maxGrade;
                    }

                    if (currentValue < 0) {
                        this.value = 0;
                    }
                });
            });

            // Edit graded essay functionality
            document.querySelectorAll('.edit-graded-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const detailId = this.getAttribute('data-detail-id');
                    const currentGrade = this.getAttribute('data-current-grade');
                    const maxGrade = this.getAttribute('data-max-grade');

                    // Set form action
                    const form = document.getElementById('editGradeForm');
                    form.action = `/penilaian/update-single-grade/${detailId}`;

                    // Set input values
                    document.getElementById('editGradeInput').value = currentGrade;
                    document.getElementById('editGradeInput').max = maxGrade;
                    document.getElementById('editMaxGrade').textContent = maxGrade;

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editGradeModal'));
                    modal.show();
                });
            });

            // Form submission confirmation
            document.getElementById('gradingForm')?.addEventListener('submit', function(e) {
                const inputs = this.querySelectorAll('.grade-input');
                let hasValues = false;

                inputs.forEach(input => {
                    if (input.value && parseFloat(input.value) >= 0) {
                        hasValues = true;
                    }
                });

                if (!hasValues) {
                    e.preventDefault();
                    alert('Silakan masukkan nilai untuk setidaknya satu essay!');
                    return false;
                }

                return confirm('Apakah Anda yakin ingin menyimpan penilaian ini?');
            });

            // Auto-hide toasts
            setTimeout(() => {
                document.querySelectorAll('.toast').forEach(toast => {
                    toast.classList.remove('show');
                });
            }, 5000);
        });
    </script>
    @include('layouts.components-backend.css')
@endsection
