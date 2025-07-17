{{-- resources/views/quiz/partials/benar-salah.blade.php --}}
<div class="mb-4">
    <h6 class="text-dark mb-3">
        <i class="ti ti-check-x text-warning me-2"></i>Pilihan Benar/Salah:
    </h6>
    
    <div class="row">
        <div class="col-md-6">
            <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == 'Benar' ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                <div class="me-3">
                    <i class="ti ti-check text-success fs-4"></i>
                </div>
                <span class="text-dark fw-medium flex-grow-1">Benar</span>
                @if ($soal->jawaban_benar == 'Benar')
                    <i class="ti ti-check-circle text-success fs-5"></i>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == 'Salah' ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                <div class="me-3">
                    <i class="ti ti-x text-danger fs-4"></i>
                </div>
                <span class="text-dark fw-medium flex-grow-1">Salah</span>
                @if ($soal->jawaban_benar == 'Salah')
                    <i class="ti ti-check-circle text-success fs-5"></i>
                @endif
            </div>
        </div>
    </div>
    
    @if(!in_array($soal->jawaban_benar, ['Benar', 'Salah']))
        <div class="alert alert-warning mt-3">
            <i class="ti ti-alert-triangle me-2"></i>
            Jawaban benar belum dipilih untuk soal benar/salah ini.
        </div>
    @endif
</div>