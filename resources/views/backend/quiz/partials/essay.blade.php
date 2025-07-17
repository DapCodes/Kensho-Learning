{{-- resources/views/backend/quiz/partials/essay.blade.php --}}
<div class="mb-4">
    <h6 class="text-dark mb-3">
        <i class="ti ti-file-text text-success me-2"></i>Soal Essay:
    </h6>
    
    <div class="bg-success-subtle border border-success rounded p-2 mb-3">
        <small class="text-success">
            <i class="ti ti-info-circle me-1"></i>
            Soal ini membutuhkan jawaban dalam bentuk uraian/essay
        </small>
    </div>
    
    <!-- Tampilan untuk admin show (tidak ada input, hanya informasi) -->
    <div class="mb-3">
        <div class="bg-light border rounded p-3">
            <div class="text-center text-muted">
                <i class="ti ti-file-text" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-2 mb-0">Soal essay membutuhkan jawaban dalam bentuk uraian bebas</p>
            </div>
        </div>
    </div>
    
    <!-- Informasi soal essay untuk admin -->
    <div class="row">
        <div class="col-md-4">
            <div class="bg-info-subtle border border-info rounded p-2">
                <small class="text-info">
                    <i class="ti ti-trophy me-1"></i>
                    Bobot: {{ $soal->bobot ?? 0 }} poin
                </small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-warning-subtle border border-warning rounded p-2">
                <small class="text-warning">
                    <i class="ti ti-user-check me-1"></i>
                    Penilaian manual
                </small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary-subtle border border-secondary rounded p-2">
                <small class="text-secondary">
                    <i class="ti ti-edit me-1"></i>
                    Jawaban uraian
                </small>
            </div>
        </div>
    </div>
    
    <!-- Informasi detail untuk admin -->
    <div class="mt-3">
        <div class="bg-light rounded p-3">
            <div class="row">
                <div class="col-md-8">
                    <h6 class="mb-2">
                        <i class="ti ti-info-circle text-info me-2"></i>
                        Informasi Soal Essay
                    </h6>
                    <p class="mb-0 text-dark">
                        Soal ini membutuhkan penilaian manual oleh pengajar. Peserta dapat menulis jawaban dalam bentuk uraian bebas dengan bobot {{ $soal->bobot ?? 0 }} poin.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        <div class="badge bg-success">
                            <i class="ti ti-check me-1"></i>
                            Soal Essay
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>